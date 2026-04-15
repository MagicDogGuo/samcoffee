const { SSMClient, GetParametersByPathCommand } = require('@aws-sdk/client-ssm')

const ssmClient = new SSMClient({ region: 'us-west-1' })

async function getParamsFromSSM() {
  const command = new GetParametersByPathCommand({
    Path: '/cafe/', // 加上結尾斜線，確保路徑完整
    WithDecryption: true,
    Recursive: true // 建議加上這個，確保子路徑也能抓到
  })
  
  const response = await ssmClient.send(command)
  const params = {}
  
  response.Parameters.forEach(p => {
    // 使用 split 抓最後一個元素，避免被路徑斜線坑到
    const parts = p.Name.split('/');
    const key = parts[parts.length - 1]; 
    params[key] = p.Value;
    
    // 同時注入到 process.env 確保後續連線能讀到
    process.env[key] = p.Value; 
  })
  
  console.log("注入的 Key 有:", Object.keys(params)); // 務必加這行看 Log
  return params
}

module.exports = { getParamsFromSSM }
