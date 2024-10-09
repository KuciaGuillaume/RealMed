import type { RequestHandler } from '@sveltejs/kit';
import { API_URL } from '$env/static/private';

export const POST: RequestHandler = async ({ request }) => {
	try {
    
    console.log("API_CALL: ", "/api/register");

    const { username, password } = await request.json();
    
    const formData = new FormData();
    formData.append('username', username);
    formData.append('password', password);

		const url = `${API_URL}/user/new`;

		const res = await fetch(url, {
			method: 'POST',
			body: formData,
		});

    if (res.ok) {
      return new Response(JSON.stringify({ message: 'User created' }), { status: 200 });
    } else {
      return new Response(JSON.stringify({ message: 'Failed to create user' }), { status: 400 });
    } 

	} catch (e) {
    console.error(e);
		return new Response(JSON.stringify({ message: 'Internal server error' }), { status: 500 });
	}
};
