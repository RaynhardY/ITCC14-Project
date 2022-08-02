import express from 'express'
import server from './node_modules/server'
import bodyParser from 'body-parser'
import multer from 'multer'
import cors from 'cors'

import {
  HistoryControllerGet,
  HistoryControllerPost,
  HistoryControllerDelete,
} from './controllers/HistoryController'

const app = express()
const upload = multer();
const router = express.Router();

app.use(cors())
app.use(bodyParser.json()); 
app.use(bodyParser.urlencoded({ extended: true })); 
app.use(upload.array()); 
app.use(express.static('public'));
app.use('/', router)

router.post('/history', HistoryControllerPost)
router.get('/history', HistoryControllerGet)
router.delete('/history', HistoryControllerDelete)

app.listen(3000)