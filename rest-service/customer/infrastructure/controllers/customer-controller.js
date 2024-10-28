const axios = require("axios");

/**
 * Registra un nuevo cliente en el sistema.
 * @param {Object} req - Request object de Express
 * @param {Object} req.body - Datos del cliente a registrar
 * @param {string} req.body.nombre - Nombre del cliente
 * @param {string} req.body.documento - Número de documento del cliente
 * @param {string} req.body.celular - Número de celular del cliente
 * @param {Object} res - Response object de Express
 * @returns {Promise<Object>} Respuesta con los datos del cliente registrado
 */
exports.registrarCliente = async (req, res) => {
    try {
        const response = await axios.post(
            "http://webserver/api/soap/clientes/registrar",
            req.body
        );
        res.json(response.data);
    } catch (error) {
        res.status(error?.status).json({
            success: false,
            cod_error: error?.status,
            message_error: error?.response?.data?.message_error,
            data: error?.response?.data?.data,
        });
    }
};
