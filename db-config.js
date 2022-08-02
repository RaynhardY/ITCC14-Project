import mysql from 'mysql'

const connection = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: '',
  database: 'raynhard_services'
})

export const DbWrite = (query) => {
  connection.query(query, function (err, result) {
    if (err) throw err
  })
}

export const DbRead = (query) => {
  return new Promise((resolve, reject) => {
    connection.query(query, function (err, result) {
      return err? reject(err): resolve(result)
    })
  })
}

export default connection