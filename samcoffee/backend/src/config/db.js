const mysql = require('mysql2/promise')

let pool = null

async function getPool() {
  if (pool) return pool

  let config
  if (process.env.NODE_ENV === 'production') {
    const { getParamsFromSSM } = require('./ssm')
    const params = await getParamsFromSSM()
    config = {
      host: params.dbUrl,
      user: params.dbUser,
      password: params.dbPassword,
      database: params.dbName,
    }
  } else {
    config = {
      host: process.env.DB_HOST,
      user: process.env.DB_USER,
      password: process.env.DB_PASSWORD,
      database: process.env.DB_NAME,
    }
  }

  pool = mysql.createPool({
    ...config,
    waitForConnections: true,
    connectionLimit: 10,
  })
  return pool
}

module.exports = { getPool }
