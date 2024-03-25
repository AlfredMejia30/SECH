const express = require('express');
const app = express();
app.use(express.json()); // para parsear solicitudes con cuerpo en formato JSON

app.post('/send-message', async (req, res) => {
    console.log(req.body);
    // los números y los datos del formulario se reciben en el cuerpo de la solicitud
    const numbers = req.body.numbers;
    const datosFormulario = req.body.datosFormulario;

    // Crear el mensaje
    const mensaje = `Nombre: ${datosFormulario.nombre}\nDescripcion: ${datosFormulario.descripcion}\nValor: ${datosFormulario.valor}\nFecha inicio: ${datosFormulario.fecha_inicio}\nFecha fin: ${datosFormulario.fecha_fin}`;

    // Envía el mensaje a cada número
    for (let i = 0; i < numbers.length; i++) {
        let chat = await client.getChatById(numbers[i] + '@c.us');
        chat.sendMessage(mensaje);
    }

    res.send({ status: 'OK', message: 'Messages sent' });
});

app.listen(3001, () => {
    console.log('Server running on port 3001');
});
