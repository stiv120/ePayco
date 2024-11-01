const express = require("express");
const router = express.Router();
const walletController = require("../controllers/wallet-controller");

const app = express();

router.post("/recargar", walletController.recargarBilletera);
router.post("/consultar-saldo", walletController.consultarSaldo);

module.exports = router;
