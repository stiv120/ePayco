const axios = require("axios");

/**
 * Realiza un pago desde una billetera.
 * @param {Object} req - Request object de Express
 * @param {Object} req.body - Datos del pago
 * @param {string} req.body.documento - Número de documento del cliente
 * @param {string} req.body.celular - Número de celular del cliente
 * @param {number} req.body.monto - Monto a pagar
 * @param {Object} res - Response object de Express
 * @returns {Promise<Object>} Respuesta con los datos de la transacción
 */
exports.realizarPago = async (req, res) => {
    try {
        const response = await axios.post(
            "http://webserver/api/soap/billeteras/transacciones/realizar-pago",
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
 * Confirma un pago pendiente.
 * @param {Object} req - Request object de Express
 * @param {Object} req.body - Datos de confirmación
 * @param {string} req.body.token - Token de confirmación
 * @param {string} req.body.session_id - ID de sesión de la transacción
 * @param {string} req.params.transaccion - ID de la transacción a confirmar
 * @param {Object} res - Response object de Express
 * @returns {Promise<Object>} Respuesta con los datos de la transacción confirmada
 */
exports.confirmarPago = async (req, res) => {
    try {
        const response = await axios.post(
            `http://webserver/api/soap/billeteras/transacciones/confirmar-pago/${req.params.transaccion}`,
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
