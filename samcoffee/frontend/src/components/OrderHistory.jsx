import { useState, useEffect } from 'react'
import { getOrders } from '../api/index.js'

export default function OrderHistory() {
  const [orders, setOrders] = useState([])
  const [loading, setLoading] = useState(true)
  const [error, setError] = useState(null)

  useEffect(() => {
    getOrders()
      .then(res => setOrders(res.data))
      .catch(() => setError('無法載入訂單記錄，請稍後再試。'))
      .finally(() => setLoading(false))
  }, [])

  if (loading) return <p className="text-center py-12 text-gray-500">載入中...</p>
  if (error) return <p className="text-center py-12 text-red-500">{error}</p>

  if (orders.length === 0) {
    return <p className="text-center py-12 text-gray-500">You have no orders at this time.</p>
  }

  return (
    <div className="max-w-4xl mx-auto space-y-6">
      {orders.map(order => (
        <div key={order.order_number} className="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
          <div className="bg-gray-50 border-b border-gray-200 px-6 py-4 flex flex-wrap justify-between gap-4 text-sm font-semibold text-gray-700">
            <span><strong>Order:</strong> #{order.order_number}</span>
            <span><strong>Date:</strong> {order.order_date_time?.substring(0, 10)}</span>
            <span><strong>Time:</strong> {order.order_date_time?.substring(11, 19)}</span>
            <span><strong>Total:</strong> NZD ${Number(order.amount).toFixed(2)}</span>
          </div>
          <table className="w-full border-collapse">
            <thead>
              <tr className="bg-gray-50">
                <th className="px-6 py-3 text-left text-sm font-semibold text-gray-600">Item</th>
                <th className="px-6 py-3 text-right text-sm font-semibold text-gray-600">Price</th>
                <th className="px-6 py-3 text-right text-sm font-semibold text-gray-600">Quantity</th>
                <th className="px-6 py-3 text-right text-sm font-semibold text-gray-600">Amount</th>
              </tr>
            </thead>
            <tbody>
              {order.items?.map((item, idx) => (
                <tr key={idx} className="border-t border-gray-100">
                  <td className="px-6 py-3 font-semibold text-gray-700">{item.product_name}</td>
                  <td className="px-6 py-3 text-right text-gray-500">NZD ${Number(item.price).toFixed(2)}</td>
                  <td className="px-6 py-3 text-right text-gray-500">{item.quantity}</td>
                  <td className="px-6 py-3 text-right text-gray-500">NZD ${Number(item.amount).toFixed(2)}</td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      ))}
    </div>
  )
}
