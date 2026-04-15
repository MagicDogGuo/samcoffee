require('dotenv').config()
const express = require('express')
const cors = require('cors')
const { getParamsFromSSM } = require('./ssm') // 假設你的 SSM 邏輯在 ssm.js

const app = express()
app.use(cors())
app.use(express.json())

async function startServer() {
  try {
    console.log('正在從 SSM 抓取配置...')
    // 1. 務必 await，保證 process.env 被填充完畢
    await getParamsFromSSM() 
    console.log('配置注入完成！')

    // 2. 在這之後才載入路由（因為路由檔案通常會初始化資料庫連線）
    app.use('/api/menu', require('./routes/menu'))
    app.use('/api/orders', require('./routes/orders'))

    app.get('/api/health', (req, res) => res.json({ status: 'ok' }))

    const PORT = process.env.PORT || 3001
    app.listen(PORT, () => console.log(`Server running on port ${PORT}`))
    
  } catch (err) {
    console.error('伺服器啟動失敗:', err)
    process.exit(1)
  }
}

// 執行啟動流程
startServer()