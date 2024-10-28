const axios = require("axios");

exports.realizarPago = async (req, res) => {
    try {
        const response = await axios.post(
            "http://webserver/api/soap/billeteras/transacciones/realizar-pago",
            req.body
        );
        res.json(response.data);
    } catch (error) {
        console.log(error);
        res.status(error?.status).json({
            success: false,
            cod_error: error?.response?.status,
            message_error: error?.response?.data?.message_error,
            data: error?.response?.data?.data,
        });
    }
};
