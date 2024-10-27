const express = require("express");
const bodyParser = require("body-parser");
const customerRoutes = require("./customer/infrastructure/routes/customer-routes.js");

const app = express();

app.use(bodyParser.json());

app.use("/cliente", customerRoutes);

const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
    console.log(`The server is running in http://localhost:${PORT}`);
});
