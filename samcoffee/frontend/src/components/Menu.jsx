import { useState, useEffect } from 'react'
import { getMenu, submitOrder } from '../api/index.js'

export default function Menu() {
  const [menuItems, setMenuItems] = useState([])
  const [quantities, setQuantities] = useState({})
  const [loading, setLoading] = useState(true)
  const [error, setError] = useState(null)
  const [submitting, setSubmitting] = useState(false)
  const [orderSuccess, setOrderSuccess] = useState(false)

  useEffect(() => {
    getMenu()
      .then(res => {
        setMenuItems(res.data)
        const initialQty = {}
        res.data.forEach(item => { initialQty[item.id] = 0 })
        setQuantities(initialQty)
      })
      .catch(() => setError('無法載入菜單，請稍後再試。'))
      .finally(() => setLoading(false))
  }, [])

  const updateQuantity = (id, value) => {
    const qty = Math.min(15, Math.max(0, Number(value)))
    setQuantities(prev => ({ ...prev, [id]: qty }))
  }

  const orderTotal = menuItems.reduce((sum, item) => {
    return sum + (quantities[item.id] || 0) * item.price
  }, 0)

  const handleReset = () => {
    const reset = {}
    menuItems.forEach(item => { reset[item.id] = 0 })
    setQuantities(reset)
    setOrderSuccess(false)
  }

  const handleSubmit = async (e) => {
    e.preventDefault()
    if (orderTotal <= 0) {
      alert('Please select at least one item to buy.')
      return
    }
    const orderItems = menuItems
      .filter(item => quantities[item.id] > 0)
      .map(item => ({
        productId: item.id,
        productName: item.product_name,
        quantity: quantities[item.id],
        price: item.price,
      }))

    setSubmitting(true)
    try {
      await submitOrder({ items: orderItems, total: orderTotal })
      setOrderSuccess(true)
      handleReset()
    } catch {
      alert('訂單送出失敗，請稍後再試。')
    } finally {
      setSubmitting(false)
    }
  }

  if (loading) return <p className="text-center py-12 text-gray-500">載入中...</p>
  if (error) return <p className="text-center py-12 text-red-500">{error}</p>

  const groups = menuItems.reduce((acc, item) => {
    const groupName = item.product_group_name || '其他'
    if (!acc[groupName]) acc[groupName] = []
    acc[groupName].push(item)
    return acc
  }, {})

  return (
    <form onSubmit={handleSubmit}>
      {orderSuccess && (
        <div className="bg-green-50 border border-green-200 rounded-lg p-6 text-center max-w-2xl mx-auto mb-8">
          <h2 className="text-2xl font-bold text-green-700 mb-2">Order Confirmed!</h2>
          <p className="text-gray-600">Thank you for your order. We'll have it ready soon!</p>
        </div>
      )}

      <div className="menu-grid">
        {Object.entries(groups).map(([groupName, items]) => (
          <div key={groupName} className="contents">
            <h3 className="col-span-full font-logo text-3xl text-coffee-brown border-b-2 border-coffee-light pb-2 mt-8">
              {groupName}
            </h3>
            {items.map(item => (
              <div
                key={item.id}
                className="bg-white rounded-lg shadow-md overflow-hidden flex flex-col text-center transition-transform duration-300 hover:-translate-y-1 hover:shadow-lg"
              >
                <img
                  src={item.image_url || '/images/default-image.jpg'}
                  alt={item.product_name}
                  className="w-full h-48 object-cover"
                  onError={e => { e.target.src = '/images/default-image.jpg' }}
                />
                <div className="p-4 flex flex-col flex-1">
                  <h2 className="text-xl font-bold text-coffee-medium mb-1">{item.product_name}</h2>
                  <p className="text-green-700 font-bold text-lg mb-1">NZD ${Number(item.price).toFixed(2)}</p>
                  <p className="text-gray-500 text-sm flex-1 mb-3">{item.description}</p>
                  <label className="text-sm text-gray-600">
                    Quantity:&nbsp;
                    <input
                      type="number"
                      min="0"
                      max="15"
                      value={quantities[item.id] || 0}
                      onChange={e => updateQuantity(item.id, e.target.value)}
                      className="w-20 px-2 py-1 border border-gray-300 rounded text-center mx-auto"
                    />
                  </label>
                </div>
              </div>
            ))}
          </div>
        ))}
      </div>

      <div className="text-center my-12 mx-auto max-w-md bg-gray-50 rounded-lg p-8 shadow-sm">
        <p className="text-2xl font-bold text-coffee-brown mb-4">
          Order Total: NZD ${orderTotal.toFixed(2)}
        </p>
        <button
          type="submit"
          disabled={submitting}
          className="bg-coffee-light hover:bg-coffee-medium text-white px-8 py-3 rounded uppercase tracking-wider font-semibold transition-colors duration-300 mx-2 disabled:opacity-50"
        >
          {submitting ? 'Submitting...' : 'Submit Order'}
        </button>
        <button
          type="button"
          onClick={handleReset}
          className="bg-gray-500 hover:bg-gray-600 text-white px-8 py-3 rounded uppercase tracking-wider font-semibold transition-colors duration-300 mx-2"
        >
          Reset Order
        </button>
      </div>
    </form>
  )
}
