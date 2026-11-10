
/**
 * TuProyecto - Realtime Notification Microservice
 * Architecture: Node.js + Redis + MongoDB + Socket.IO
 *
 * Listens to Laravel Redis broadcast events and pushes live
 * notifications to browsers while persisting data in MongoDB.
 */

import express from 'express';
import http from 'http';
import SocketIOServer from 'socket.io';
import Redis from 'ioredis';
import mongoose from 'mongoose';
import path from 'path';
import { fileURLToPath } from 'url';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

// -------------------------------------------------------------
// 1. Configuration
// -------------------------------------------------------------
const CONFIG = {
    port: process.env.REALTIME_PORT || 8443,
    host: process.env.REALTIME_HOST || '0.0.0.0',
    mongo: {
        uri: process.env.MDB_URI || 'mongodb://127.0.0.1:27018/tuproyecto'
    },
    redis: {
        host: process.env.REDIS_HOST || '127.0.0.1',
        port: parseInt(process.env.REDIS_PORT || '6380', 10)
    }
};

const typeNotify = {
    general: 1,
    friendship: 2,
    like: 3,
    favorite: 4,
    discussion: 5
};

// -------------------------------------------------------------
// 2. Mongoose Schemas & Models
// -------------------------------------------------------------
const { Schema } = mongoose;

const userSchema = new Schema({
    cod: { type: Number, unique: true, required: true },
    name: { type: String, default: '' },
    nickname: { type: String, default: '' },
    avatar: { type: String, default: '' },
    username: { type: String, default: '' },
    password: { type: String, default: '' }
}, { timestamps: true });

userSchema.statics.saveOne = async function (attrs) {
    if (!attrs || !attrs.cod) return null;
    return this.findOneAndUpdate(
        { cod: attrs.cod },
        {
            $set: {
                name: attrs.name || '',
                nickname: attrs.nickname || '',
                avatar: attrs.avatar || '',
                username: attrs.username || attrs.nickname || ''
            }
        },
        { upsert: true, new: true, setDefaultsOnInsert: true }
    );
};

const notificationSchema = new Schema({
    title: { type: String, trim: true, default: '' },
    content: { type: String, trim: true, default: '' },
    image: { type: String, default: '' },
    receivedBy: [{ type: Schema.Types.ObjectId, ref: 'User' }],
    deliveredBy: [{ type: Schema.Types.ObjectId, ref: 'User' }],
    readBy: [{ type: Schema.Types.ObjectId, ref: 'User' }],
    deletedBy: [{ type: Schema.Types.ObjectId, ref: 'User' }],
    openedBy: [{ type: Schema.Types.ObjectId, ref: 'User' }],
    isGlobal: { type: Boolean, default: false },
    created: { type: Date, default: Date.now },
    updated: { type: Date, default: Date.now },
    institution: { type: Number, default: 0 },
    url: { type: String, default: '' },
    type: { type: Number, default: 1 },
    resource: { type: Number, default: 0 },
    module: { type: Number, default: 0 }
});

const User = mongoose.model('User', userSchema);
const Notification = mongoose.model('Notification', notificationSchema);

// -------------------------------------------------------------
// 3. Express App & HTTP Server
// -------------------------------------------------------------
const app = express();
app.use(express.json());

// Health check endpoint
app.get('/health', (req, res) => {
    res.json({
        status: 'ok',
        service: 'tuproyecto-realtime',
        timestamp: new Date().toISOString(),
        mongo: mongoose.connection.readyState === 1 ? 'connected' : 'disconnected',
        activeSockets: Object.keys(ioUsers).length
    });
});

// API: List recent notifications from MongoDB
app.get('/api/notifications', async (req, res) => {
    try {
        const notifs = await Notification.find().sort({ created: -1 }).limit(20);
        res.json({ success: true, count: notifs.length, notifications: notifs });
    } catch (e) {
        res.status(500).json({ success: false, error: e.message });
    }
});

// API: Send test notification via Redis
app.post('/api/test-notify', async (req, res) => {
    try {
        const { title, content, isGlobal, cod, institution } = req.body;
        const payload = {
            data: {
                title: title || 'Notificación desde Navegador',
                content: content || 'Mensaje de prueba emitido en tiempo real',
                isGlobal: isGlobal !== undefined ? Boolean(isGlobal) : true,
                receivedBy: cod ? [parseInt(cod, 10)] : [],
                deliveredBy: cod ? parseInt(cod, 10) : 0,
                institution: institution ? parseInt(institution, 10) : 30,
                type: 1
            }
        };
        await redisPub.publish('notification-channel', JSON.stringify(payload));
        res.json({ success: true, message: 'Evento emitido a Redis exitosamente' });
    } catch (e) {
        res.status(500).json({ success: false, error: e.message });
    }
});

// API: Delete a notification from MongoDB
app.delete('/api/notifications/:id', async (req, res) => {
    try {
        await Notification.findByIdAndDelete(req.params.id);
        res.json({ success: true, message: 'Documento eliminado de MongoDB' });
    } catch (e) {
        res.status(500).json({ success: false, error: e.message });
    }
});

// Web UI: Interactive Test Dashboard in Browser
app.get('/', (req, res) => {
    res.send(`<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TuProyecto - Panel de Prueba MongoDB & Realtime</title>
    <style>
        :root { --primary: #0284c7; --primary-hover: #0369a1; --bg: #f8fafc; --card: #ffffff; --border: #e2e8f0; --text: #1e293b; }
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; background: var(--bg); color: var(--text); margin: 0; padding: 24px; }
        .container { max-width: 960px; margin: 0 auto; }
        header { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid var(--border); padding-bottom: 16px; margin-bottom: 24px; }
        h1 { margin: 0; font-size: 24px; color: #0f172a; }
        .badge { display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px; border-radius: 9999px; font-size: 13px; font-weight: 600; }
        .badge-green { background: #dcfce7; color: #15803d; }
        .badge-red { background: #fee2e2; color: #b91c1c; }
        .dot { width: 8px; height: 8px; border-radius: 50%; background: currentColor; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .card { background: var(--card); border: 1px solid var(--border); border-radius: 8px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .card h2 { margin-top: 0; font-size: 18px; border-bottom: 1px solid var(--border); padding-bottom: 10px; }
        label { display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px; color: #475569; }
        input, textarea, select { width: 100%; box-sizing: border-box; padding: 10px; border: 1px solid var(--border); border-radius: 6px; font-size: 14px; margin-bottom: 12px; }
        button { background: var(--primary); color: white; border: none; padding: 10px 18px; border-radius: 6px; font-size: 14px; font-weight: 600; cursor: pointer; transition: 0.2s; }
        button:hover { background: var(--primary-hover); }
        .log-box { background: #0f172a; color: #38bdf8; font-family: monospace; font-size: 12px; padding: 14px; border-radius: 6px; max-height: 240px; overflow-y: auto; }
        .table-wrap { overflow-x: auto; margin-top: 14px; }
        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        th, td { text-align: left; padding: 10px; border-bottom: 1px solid var(--border); }
        th { background: #f1f5f9; color: #475569; }
        .btn-sm { padding: 4px 8px; font-size: 11px; background: #ef4444; }
        .btn-sm:hover { background: #dc2626; }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <div>
                <h1>TuProyecto Realtime Dashboard</h1>
                <p style="margin: 4px 0 0; color: #64748b; font-size: 14px;">Prueba interactiva en navegador para MongoDB, Redis y WebSockets</p>
            </div>
            <div style="display: flex; gap: 8px;">
                <span id="ws-badge" class="badge badge-red"><span class="dot"></span> WebSocket Desconectado</span>
                <span id="mongo-badge" class="badge badge-green"><span class="dot"></span> MongoDB Conectado</span>
            </div>
        </header>

        <div class="grid">
            <div class="card">
                <h2>1. Emitir Notificación de Prueba</h2>
                <form id="notify-form">
                    <label>Título de la Notificación</label>
                    <input type="text" id="title" value="Aviso importante desde Navegador" required>

                    <label>Mensaje / Contenido</label>
                    <textarea id="content" rows="2" required>Esta notificación viaja por Redis, se guarda en MongoDB y se emite por WebSocket.</textarea>

                    <label>Alcance</label>
                    <select id="scope">
                        <option value="global">Global (isGlobal: true - Todos los usuarios)</option>
                        <option value="user">Usuario Específico (cod: 455173)</option>
                    </select>

                    <button type="submit">Enviar a Redis ➔ MongoDB ➔ Sockets</button>
                </form>
            </div>

            <div class="card">
                <h2>2. Consola de Eventos en Tiempo Real (WebSocket)</h2>
                <p style="margin-top: 0; color: #64748b; font-size: 13px;">Canal: <code>/nsp-notify</code> (Socket.IO)</p>
                <div class="log-box" id="logs">Esperando conexión de WebSocket...\\n</div>
            </div>
        </div>

        <div class="card" style="margin-top: 20px;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h2>3. Documentos Físicos en MongoDB (Colección: <code>notifications</code>)</h2>
                <button onclick="loadMongoDocs()" style="background: #475569; padding: 6px 12px; font-size: 12px;">Refrescar MongoDB</button>
            </div>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>_id (MongoDB)</th>
                            <th>Título</th>
                            <th>Contenido</th>
                            <th>Tipo</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="mongo-table">
                        <tr><td colspan="6" style="text-align: center; color: #94a3b8;">Cargando documentos de MongoDB...</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="/socket.io/socket.io.js"></script>
    <script>
        const logs = document.getElementById('logs');
        const wsBadge = document.getElementById('ws-badge');
        function addLog(msg) {
            const time = new Date().toLocaleTimeString();
            logs.innerHTML += '[' + time + '] ' + msg + '\\n';
            logs.scrollTop = logs.scrollHeight;
        }

        // Conectar al namespace de Socket.IO
        const socket = io('/nsp-notify');

        socket.on('connect', () => {
            wsBadge.className = 'badge badge-green';
            wsBadge.innerHTML = '<span class="dot"></span> WebSocket Conectado';
            addLog('Conectado al servidor Socket.IO (ID: ' + socket.id + ')');
            socket.emit('checkuser', { cod: 455173 });
        });

        socket.on('disconnect', () => {
            wsBadge.className = 'badge badge-red';
            wsBadge.innerHTML = '<span class="dot"></span> WebSocket Desconectado';
            addLog('Desconectado del servidor.');
        });

        socket.on('notification-channel:App\\\\Events\\\\Notification', (data) => {
            addLog('¡PUSH RECIBIDO! "' + data.title + '" - ' + data.content);
            loadMongoDocs();
        });

        // Cargar documentos desde MongoDB
        async function loadMongoDocs() {
            try {
                const res = await fetch('/api/notifications');
                const data = await res.json();
                const tbody = document.getElementById('mongo-table');
                if (!data.notifications || data.notifications.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="6" style="text-align: center; color: #94a3b8;">No hay documentos en MongoDB.</td></tr>';
                    return;
                }
                tbody.innerHTML = data.notifications.map(n => \`
                    <tr>
                        <td><code style="color: #0284c7;">\${n._id}</code></td>
                        <td><strong>\${n.title}</strong></td>
                        <td>\${n.content}</td>
                        <td>\${n.isGlobal ? '<span style="color: #16a34a; font-weight:600;">Global</span>' : 'Usuario'}</td>
                        <td style="color: #64748b;">\${new Date(n.created).toLocaleString()}</td>
                        <td><button class="btn-sm" onclick="deleteDoc('\${n._id}')">Eliminar</button></td>
                    </tr>
                \`).join('');
            } catch (err) {
                console.error(err);
            }
        }

        async function deleteDoc(id) {
            if (!confirm('¿Eliminar este documento de MongoDB?')) return;
            await fetch('/api/notifications/' + id, { method: 'DELETE' });
            addLog('Documento eliminado de MongoDB: ' + id);
            loadMongoDocs();
        }

        document.getElementById('notify-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            const title = document.getElementById('title').value;
            const content = document.getElementById('content').value;
            const scope = document.getElementById('scope').value;

            addLog('Enviando evento a Redis...');
            const res = await fetch('/api/test-notify', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    title,
                    content,
                    isGlobal: scope === 'global',
                    cod: scope === 'user' ? 455173 : null
                })
            });
            const data = await res.json();
            if (data.success) {
                addLog('Evento publicado en Redis con éxito.');
            }
        });

        loadMongoDocs();
    </script>
</body>
</html>`);
});

const server = http.createServer(app);

// -------------------------------------------------------------
// 4. Socket.IO Setup
// -------------------------------------------------------------
const io = new SocketIOServer(server, {
    cors: {
        origin: '*',
        methods: ['GET', 'POST'],
        credentials: true
    },
    transports: ['websocket', 'polling']
});

const nspNotify = io.of('/nsp-notify');
const ioUsers = {}; // Map of user.cod -> Set of socket IDs

async function getUserNotificationsAndCount(cod) {
    let userDoc = await User.findOne({ cod });
    if (!userDoc) {
        userDoc = await User.create({ cod });
    }

    const filter = {
        $or: [
            { receivedBy: userDoc._id },
            { isGlobal: true }
        ],
        deletedBy: { $nin: [userDoc._id] }
    };

    const notifications = await Notification.find(filter)
        .sort({ created: -1 })
        .limit(15)
        .lean();

    const unreadCount = await Notification.countDocuments({
        ...filter,
        readBy: { $nin: [userDoc._id] }
    });

    const formattedNots = notifications.map(n => ({
        ...n,
        id: n._id.toString(),
        created: n.created ? n.created.toISOString() : new Date().toISOString()
    }));

    return { notifications: formattedNots, unreadCount };
}

nspNotify.on('connection', (socket) => {
    let currentCod = null;
    console.log(`[Socket.IO] Cliente conectado a /nsp-notify: ${socket.id}`);

    socket.on('checkuser', async (data) => {
        try {
            console.log(`[Socket.IO] checkuser recibido de ${socket.id}:`, data);
            let cod = data && (data.cod || data.id);
            if (!cod && socket.handshake && socket.handshake.headers && socket.handshake.headers.cookie) {
                const match = socket.handshake.headers.cookie.match(/_user_id=(\d+)/);
                if (match) {
                    cod = match[1];
                    console.log(`[Socket.IO] cod extraído de cookie: ${cod}`);
                }
            }
            if (!cod) {
                cod = 455173; // Fallback automático para Compensar en entorno local
                console.log(`[Socket.IO] cod fallback Compensar: ${cod}`);
            }
            if (cod) {
                currentCod = parseInt(cod, 10);
                if (!ioUsers[currentCod]) {
                    ioUsers[currentCod] = new Set();
                }
                ioUsers[currentCod].add(socket.id);
                console.log(`[Socket.IO] Usuario conectado: cod=${currentCod} (Socket ID: ${socket.id})`);

                // Send initial notifications and unread count to populate bell & dropdown
                const { notifications, unreadCount } = await getUserNotificationsAndCount(currentCod);
                socket.emit('unreadCount', { count: unreadCount });
                socket.emit('sendNotifications', notifications, unreadCount, 1);
                console.log(`[Socket.IO] Enviadas ${notifications.length} notificaciones (no leídas: ${unreadCount}) a cod=${currentCod}`);
            }
        } catch (err) {
            console.error('[Socket.IO] Error en checkuser:', err.message);
        }
    });

    socket.on('markRead', async (data) => {
        try {
            if (currentCod && data && data.notificationId) {
                const userDoc = await User.findOne({ cod: currentCod });
                if (userDoc) {
                    await Notification.updateOne(
                        { _id: data.notificationId },
                        { $addToSet: { readBy: userDoc._id } }
                    );
                    socket.emit('markedRead', { success: true, id: data.notificationId });
                }
            }
        } catch (err) {
            console.error('[Socket.IO] Error en markRead:', err.message);
        }
    });

    socket.on('disconnect', () => {
        if (currentCod && ioUsers[currentCod]) {
            ioUsers[currentCod].delete(socket.id);
            if (ioUsers[currentCod].size === 0) {
                delete ioUsers[currentCod];
            }
            console.log(`[Socket.IO] Usuario desconectado: cod=${currentCod}`);
        }
    });
});

// -------------------------------------------------------------
// 5. Redis Client & Event Handling
// -------------------------------------------------------------
const redis = new Redis(CONFIG.redis.port, CONFIG.redis.host, {
    retryStrategy: (times) => Math.min(times * 1000, 5000)
});
const redisPub = new Redis(CONFIG.redis.port, CONFIG.redis.host, {
    retryStrategy: (times) => Math.min(times * 1000, 5000)
});

redis.on('connect', () => {
    console.log(`[Redis Sub] Conectado exitosamente en ${CONFIG.redis.host}:${CONFIG.redis.port}`);
});

redis.on('error', (err) => {
    console.error('[Redis Sub] Error de conexión:', err.message);
});

redisPub.on('error', (err) => {
    console.error('[Redis Pub] Error de conexión:', err.message);
});

async function handleUserChannelMessage(payload) {
    try {
        const data = payload.data || payload;
        if (data && data.cod) {
            const saved = await User.saveOne(data);
            console.log(`[MongoDB] Usuario sincronizado en 'users': cod=${saved.cod} (${saved.name || saved.nickname})`);
        }
    } catch (err) {
        console.error('[UserChannel] Error procesando usuario:', err.message);
    }
}

async function handleNotificationChannelMessage(payload) {
    try {
        const data = payload.data || payload;
        if (!data) return;

        // Resolve deliveredBy user in MongoDB
        let deliveredByDoc = null;
        if (data.deliveredBy) {
            deliveredByDoc = await User.findOne({ cod: parseInt(data.deliveredBy, 10) });
        }

        // Resolve receivedBy users in MongoDB
        let receivedByDocs = [];
        let recipientCods = [];
        if (data.receivedBy) {
            recipientCods = Array.isArray(data.receivedBy) ? data.receivedBy : [data.receivedBy];
            recipientCods = recipientCods.map(c => parseInt(c, 10)).filter(c => !isNaN(c));
            if (recipientCods.length > 0) {
                for (const rCod of recipientCods) {
                    let uDoc = await User.findOne({ cod: rCod });
                    if (!uDoc) {
                        uDoc = await User.create({ cod: rCod });
                    }
                    receivedByDocs.push(uDoc);
                }
            }
        }

        const isGlobal = Boolean(data.isGlobal);

        // Create notification document in MongoDB
        const notifDoc = new Notification({
            title: data.title || '',
            content: data.content || '',
            image: data.image || '',
            receivedBy: receivedByDocs.map(u => u._id),
            deliveredBy: deliveredByDoc ? [deliveredByDoc._id] : [],
            isGlobal: isGlobal,
            institution: parseInt(data.institution || '0', 10),
            url: data.url || '',
            type: parseInt(data.type || typeNotify.general, 10),
            resource: parseInt(data.resource || '0', 10),
            module: parseInt(data.module || '0', 10),
            created: new Date()
        });

        await notifDoc.save();
        console.log(`[MongoDB] Notificación guardada en 'notifications': ID=${notifDoc._id} - "${notifDoc.title}"`);

        // Emit via Socket.IO to connected clients
        const clientPayload = {
            id: notifDoc._id,
            title: notifDoc.title,
            content: notifDoc.content,
            image: notifDoc.image,
            url: notifDoc.url,
            type: notifDoc.type,
            created: notifDoc.created
        };

        if (isGlobal) {
            nspNotify.emit('notification-channel:App\\Events\\Notification', clientPayload);
            console.log(`[Socket.IO] Push broadcast global enviado a todos los sockets conectados.`);
            for (const codStr of Object.keys(ioUsers)) {
                const cod = parseInt(codStr, 10);
                const { notifications, unreadCount } = await getUserNotificationsAndCount(cod);
                ioUsers[cod].forEach(socketId => {
                    nspNotify.to(socketId).emit('sendNotifications', notifications, unreadCount, 1);
                });
            }
        } else {
            for (const cod of recipientCods) {
                const socketIds = ioUsers[cod];
                if (socketIds && socketIds.size > 0) {
                    const { notifications, unreadCount } = await getUserNotificationsAndCount(cod);
                    socketIds.forEach(socketId => {
                        nspNotify.to(socketId).emit('notification-channel:App\\Events\\Notification', clientPayload);
                        nspNotify.to(socketId).emit('sendNotifications', notifications, unreadCount, notifDoc.type || 1);
                    });
                    console.log(`[Socket.IO] Push y sendNotifications enviado a usuario cod=${cod} (${socketIds.size} socket(s)).`);
                }
            }
        }
    } catch (err) {
        console.error('[NotificationChannel] Error procesando notificación:', err.message);
    }
}

// -------------------------------------------------------------
// 6. Bootstrap & Startup
// -------------------------------------------------------------
async function bootstrap() {
    try {
        console.log('='.repeat(60));
        console.log('TuProyecto - Microservicio de Notificaciones en Tiempo Real');
        console.log('='.repeat(60));

        // Connect to MongoDB
        console.log(`[MongoDB] Conectando a ${CONFIG.mongo.uri}...`);
        await mongoose.connect(CONFIG.mongo.uri, {
            useNewUrlParser: true,
            useUnifiedTopology: true
        });
        console.log('[MongoDB] Conexión establecida exitosamente.');

        // Subscribe to Redis channels
        await redis.subscribe('user-channel', 'notification-channel');
        console.log('[Redis] Suscrito a canales: user-channel, notification-channel');

        redis.on('message', (channel, message) => {
            try {
                const parsed = JSON.parse(message);
                if (channel === 'user-channel') {
                    handleUserChannelMessage(parsed);
                } else if (channel === 'notification-channel') {
                    handleNotificationChannelMessage(parsed);
                }
            } catch (err) {
                console.error(`[Redis] Error parseando mensaje en ${channel}:`, err.message);
            }
        });

        // Start HTTP + Socket.IO server
        server.listen(CONFIG.port, CONFIG.host, () => {
            console.log(`[Server] Microservicio escuchando en http://${CONFIG.host}:${CONFIG.port}`);
            console.log(`[Server] Socket.IO namespace disponible en: /nsp-notify`);
            console.log(`[Server] Endpoint de salud: http://localhost:${CONFIG.port}/health`);
            console.log('='.repeat(60));
        });

    } catch (err) {
        console.error('[Bootstrap] Error fatal iniciando el microservicio:', err);
        process.exit(1);
    }
}

// Graceful shutdown
function shutdown() {
    console.log('\n[Server] Deteniendo microservicio...');
    server.close(() => {
        mongoose.disconnect().then(() => {
            Promise.all([redis.quit(), redisPub.quit()]).then(() => {
                console.log('[Server] Conexiones cerradas limpiamente.');
                process.exit(0);
            });
        });
    });
}

process.on('SIGINT', shutdown);
process.on('SIGTERM', shutdown);

bootstrap();
