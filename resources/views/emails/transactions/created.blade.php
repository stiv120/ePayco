<!DOCTYPE html>
<html>
<head>
    <title>Nueva Transacción</title>
</head>
<body>
    <h1>Nueva Transacción Creada</h1>

    <p>Se ha creado una nueva transacción con los siguientes detalles:</p>

    <ul>
        <li><strong>Token:</strong> {{ $token }}</li>
        <li><strong>ID de Sesión:</strong> {{ $sessionId }}</li>
        <li><strong>Monto:</strong> ${{ number_format($monto, 2) }}</li>
    </ul>

    <p>Por favor, guarde estos datos para futuras referencias.</p>
</body>
</html>
