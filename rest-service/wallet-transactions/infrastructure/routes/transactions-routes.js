const express = require("express");
const router = express.Router();
const transactionsController = require("../controllers/transactions-controller");

router.post("/realizar-pago", transactionsController.realizarPago);

module.exports = router;
