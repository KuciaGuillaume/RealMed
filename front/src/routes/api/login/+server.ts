import type { RequestHandler } from '@sveltejs/kit';
import { API_URL } from '$env/static/private';

export const POST: RequestHandler = async ({ request, cookies, fetch }) => {
	try {
		console.log('API_CALL: ', '/login');

		const { username, password } = await request.json();

		const formData = new FormData();
		formData.append('username', username);
		formData.append('password', password);

		const url = `${API_URL}/login`;

		const res = await fetch(url, {
			method: 'POST',
			body: formData,
			credentials: 'include'
		});

		if (res.ok) {
			// Extract the 'Set-Cookie' header from the response
			const setCookieHeader = res.headers.get('set-cookie');

			if (setCookieHeader) {
				// Split multiple cookies if present
				const cookiesArray = setCookieHeader.split(', ');

				for (const cookieStr of cookiesArray) {
					// Parse each cookie string
					const [nameValue, ...optionsParts] = cookieStr.split(';').map((part) => part.trim());
					const [name, value] = nameValue.split('=');

					const options: { 
						path: string; 
						expires?: Date; 
						maxAge?: number; 
						domain?: string; 
						secure?: boolean; 
						httpOnly?: boolean; 
						sameSite?: 'strict' | 'lax' | 'none'; 
					} = { path: '/' }; // Initialize with default path '/'

					for (const option of optionsParts) {
						const [optName, optValue] = option.split('=');
						switch (optName.toLowerCase()) {
							case 'path':
								options.path = optValue || '/'; // Ensure path is always a string
								break;
							case 'expires':
								options.expires = new Date(optValue);
								break;
							case 'max-age':
								options.maxAge = parseInt(optValue, 10);
								break;
							case 'domain':
								options.domain = optValue;
								break;
							case 'secure':
								options.secure = true;
								break;
							case 'httponly':
								options.httpOnly = true;
								break;
							case 'samesite':
								options.sameSite = optValue as 'strict' | 'lax' | 'none';
								break;
						}
					}

					// Set the cookie using SvelteKit's cookies API
					cookies.set(name, value, options);
				}
			}

			return new Response(JSON.stringify({ message: 'Login successful' }), { status: 200 });
		} else {
			return new Response(JSON.stringify({ message: 'Login failed' }), { status: 400 });
		}
	} catch (e) {
		console.error(e);
		return new Response(JSON.stringify({ message: 'Internal server error' }), { status: 500 });
	}
};