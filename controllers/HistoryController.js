import { DbRead, DbWrite } from "../db-config"
import { column_converted_value, column_from, column_to, column_value, table } from "../models/HistoryModel"

export const HistoryControllerGet = async (request, response) => {
  const query = GetHistory()
  const historyList = await DbRead(query)

  response.send({
    'success': true,
    'data': historyList
  })
} 

export const HistoryControllerPost = (request, response) => {
  const data = request.body

  const result = convertion(data.from, data.value)
  const query = SaveToHistory(data, result[data.to])
  DbWrite(query)

  response.send({
    success: true,
  })
}

export const HistoryControllerDelete = (request, response) => {
  const data = request.body

  const query = DeleteItemInHistory(data.id)
  DbWrite(query)

  response.send({
    success: true,
  })
}

const SaveToHistory = (data, result) => {
  return 'INSERT INTO `' + table + '` (`' 
    + column_value + '`, `' + column_from + '`, `' + column_to  + '`, `' + column_converted_value
    + '`) VALUES (\'' 
    + data.value + '\', \'' + data.from + '\', \'' + data.to  + '\', \'' + result
    + '\')'
}

const convertion = (constant, value) => {
  switch(constant) {
    case 'cm':
      return {
        cm: value,
        m: value * 0.01,
        km: value / 100000,
      }

    case 'm':
      return {
        cm: value * 100,
        m: value,
        km: value * 0.001,
      }

    case 'km':
      return {
        cm: value * 100000,
        m: value * 1000,
        km: value,
      }
    default:
      return {
        cm: value,
        m: value,
        km: value,
      }
  }
}

const GetHistory = () => {
  return 'SELECT * FROM ' + table
}

const DeleteItemInHistory = (id) => {
  return "DELETE FROM " + table + " WHERE `id` = " + id
}