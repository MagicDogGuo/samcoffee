const express = require('express')
const router = express.Router()
const { getPool } = require('../config/db')

// GET /api/orders
// 回傳所有訂單（含明細），依訂單編號降序排列
router.get('/', async (req, res) => {
  try {
    const pool = await getPool()
    const [rows] = await pool.query(`
      SELECT
        a.order_number,
        a.order_date_time,
        a.amount,
        b.order_item_number,
        b.product_id,
        b.quantity,
        b.amount  AS item_amount,
        c.product_name,
        c.price
      FROM \`order\` a
      JOIN order_item b ON a.order_number = b.order_number
      JOIN product    c ON c.id = b.product_id
      ORDER BY a.order_number DESC, b.order_item_number ASC
    `)

    // 將平坦的資料列組合成巢狀結構 { order_number, order_date_time, amount, items: [] }
    const ordersMap = new Map()
    rows.forEach(row => {
      if (!ordersMap.has(row.order_number)) {
        ordersMap.set(row.order_number, {
          order_number: row.order_number,
          order_date_time: row.order_date_time,
          amount: row.amount,
          items: [],
        })
      }
      ordersMap.get(row.order_number).items.push({
        order_item_number: row.order_item_number,
        product_id: row.product_id,
        product_name: row.product_name,
        price: row.price,
        quantity: row.quantity,
        amount: row.item_amount,
      })
    })

    res.json([...ordersMap.values()])
  } catch (err) {
    console.error('GET /api/orders error:', err)
    res.status(500).json({ error: 'Failed to fetch orders' })
  }
})

// POST /api/orders
// 新增訂單，Body: { items: [{ productId, productName, quantity, price }], total }
router.post('/', async (req, res) => {
  const { items, total } = req.body

  if (!items || items.length === 0 || total <= 0) {
    return res.status(400).json({ error: 'Invalid order data' })
  }

  const pool = await getPool()
  const conn = await pool.getConnection()
  try {
    await conn.beginTransaction()

    // 插入 order 主表
    const now = new Date().toISOString().slice(0, 19).replace('T', ' ')
    const [orderResult] = await conn.execute(
      'INSERT INTO `order` (order_date_time, amount) VALUES (?, ?)',
      [now, total]
    )
    const orderNumber = orderResult.insertId

    // 插入 order_item 明細
    let itemNo = 1
    for (const item of items) {
      const itemAmount = item.quantity * item.price
      await conn.execute(
        'INSERT INTO order_item (order_number, order_item_number, product_id, quantity, amount) VALUES (?, ?, ?, ?, ?)',
        [orderNumber, itemNo, item.productId, item.quantity, itemAmount]
      )
      itemNo++
    }

    await conn.commit()
    res.status(201).json({ order_number: orderNumber, order_date_time: now, amount: total })
  } catch (err) {
    await conn.rollback()
    console.error('POST /api/orders error:', err)
    res.status(500).json({ error: 'Failed to place order' })
  } finally {
    conn.release()
  }
})

module.exports = router
