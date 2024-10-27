const express = require("express");
const router = express.Router();
const customerController = require("../controllers/customer-controller");

router.post("/registrar", customerController.registrarCliente);

module.exports = router;
