const { SSMClient, GetParametersByPathCommand } = require('@aws-sdk/client-ssm')

const ssmClient = new SSMClient({ region: 'us-west-1' })

async function getParamsFromSSM() {
  const command = new GetParametersByPathCommand({
    Path: '/cafe',
    WithDecryption: true,
  })
  const response = await ssmClient.send(command)
  const params = {}
  response.Parameters.forEach(p => {
    const key = p.Name.replace('/cafe/', '')
    params[key] = p.Value
  })
  return params
}

module.exports = { getParamsFromSSM }
