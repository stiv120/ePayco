const express = require("express");
const router = express.Router();
const transactionsController = require("../controllers/transactions-controller");

router.post("/realizar-pago", transactionsController.realizarPago);
router.post(
    "/confirmar-pago/:transaccion",
    transactionsController.confirmarPago
);

module.exports = router;
