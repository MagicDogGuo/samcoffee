const mysql = require('mysql2/promise')

let pool = null

async function getPool() {
  if (pool) return pool

  // app.js 啟動時已透過 getParamsFromSSM() 將 SSM 參數注入 process.env
  // 本地開發時，請在 .env 中使用相同的 key 名稱（dbUrl、dbUser、dbPassword、dbName）
  pool = mysql.createPool({
    host: process.env.dbUrl,
    user: process.env.dbUser,
    password: process.env.dbPassword,
    database: process.env.dbName,
    waitForConnections: true,
    connectionLimit: 10,
  })
  return pool
}

module.exports = { getPool }
