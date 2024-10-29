const axios = require("axios");

/**
 * Recarga el saldo de una billetera.
 * @param {Object} req - Request object de Express
 * @param {Object} req.body - Datos de la recarga
 * @param {string} req.body.documento - Número de documento del cliente
 * @param {string} req.body.celular - Número de celular del cliente
 * @param {number} req.body.valor - Monto a recargar
 * @param {Object} res - Response object de Express
 * @returns {Promise<Object>} Respuesta con los datos de la recarga
 */
exports.recargarBilletera = async (req, res) => {
    try {
        const response = await axios.post(
            "http://webserver/api/soap/billeteras/recargar",
            req.body
        );
        res.json(response.data);
    } catch (error) {
        res.status(error?.status).json({
            success: false,
            cod_error: error?.response?.status,
            message_error: error?.response?.data?.message_error,
            data: error?.response?.data?.data,
        });
    }
};

/**
 * Consulta el saldo disponible de una billetera.
 * @param {Object} req - Request object de Express
 * @param {Object} req.body - Datos de consulta
 * @param {string} req.body.documento - Número de documento del cliente
 * @param {string} req.body.celular - Número de celular del cliente
 * @param {Object} res - Response object de Express
 * @returns {Promise<Object>} Respuesta con el saldo disponible
 */
exports.consultarSaldo = async (req, res) => {
    try {
        const response = await axios.post(
            "http://webserver/api/soap/billeteras/consultar-saldo",
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
