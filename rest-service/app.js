const express = require("express");
const bodyParser = require("body-parser");
const walletRoutes = require("./wallet/infrastructure/routes/wallet-routes.js");
const customerRoutes = require("./customer/infrastructure/routes/customer-routes.js");
const walletTransactionsRoutes = require("./wallet-transactions/infrastructure/routes/transactions-routes.js");
const app = express();

app.use(bodyParser.json());

app.use("/clientes", customerRoutes);
app.use("/billeteras", walletRoutes);
app.use("/transacciones-billeteras", walletTransactionsRoutes);

const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
    console.log(`The server is running in http://localhost:${PORT}`);
});
