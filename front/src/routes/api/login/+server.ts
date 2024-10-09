import type { RequestHandler } from '@sveltejs/kit';
import { API_URL } from '$env/static/private';

export const POST: RequestHandler = async ({ request }) => {
	try {
    
    console.log("API_CALL: ", "/login");

    const { username, password } = await request.json();
    
    const formData = new FormData();
    formData.append('username', username);
    formData.append('password', password);

		const url = `${API_URL}/login`;

		const res = await fetch(url, {
			method: 'POST',
			body: formData,
      credentials: 'include',
		});

    if (res.ok) {
      return new Response(JSON.stringify({ message: 'Login successful' }), { status: 200 });
    } else {
      return new Response(JSON.stringify({ message: 'Login failed' }), { status: 400 });
    } 

	} catch (e) {
    console.error(e);
		return new Response(JSON.stringify({ message: 'Internal server error' }), { status: 500 });
	}
};
