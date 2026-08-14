// Notification main file app

export default async function () {
	// Import models and controllers
	
	const User = await (await import('./models/user')).default();
    (await import('./models/notification')).default();
	 require('./controllers/notifications');

	// Return attributes
	return { User };
}
