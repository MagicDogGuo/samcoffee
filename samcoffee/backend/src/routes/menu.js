const express = require('express')
const router = express.Router()
const { getPool } = require('../config/db')

// GET /api/menu
// 回傳所有商品（含分類資訊），依分類編號與商品 id 排序
router.get('/', async (req, res) => {
  try {
    const pool = await getPool()
    const [rows] = await pool.query(`
      SELECT
        a.id,
        a.product_name,
        a.description,
        a.price,
        a.image_url,
        b.product_group_number,
        b.product_group_name
      FROM product a
      JOIN product_group b ON b.product_group_number = a.product_group
      ORDER BY b.product_group_number, a.id
    `)
    res.json(rows)
  } catch (err) {
    console.error('GET /api/menu error:', err)
    res.status(500).json({ error: 'Failed to fetch menu' })
  }
})

module.exports = router
