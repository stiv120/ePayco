const express = require("express");
const router = express.Router();
const walletController = require("../controllers/wallet-controller");

router.post("/recargar", walletController.recargarBilletera);

module.exports = router;
