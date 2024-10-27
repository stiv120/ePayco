const axios = require("axios");

exports.registrarCliente = async (req, res) => {
    try {
        const response = await axios.post(
            "http://webserver/api/soap/cliente/registrar",
            req.body
        );
        res.json(response.data);
    } catch (error) {
        console.log(error?.status);
        res.status(error?.status).json({
            success: false,
            cod_error: error?.status,
            message_error: error?.response?.data?.message_error,
            data: error?.response?.data?.data,
        });
    }
};
