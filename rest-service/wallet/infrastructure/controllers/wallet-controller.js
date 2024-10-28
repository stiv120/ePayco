const axios = require("axios");

exports.recargarBilletera = async (req, res) => {
    try {
        const response = await axios.post(
            "http://webserver/api/soap/billeteras/recargar",
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
