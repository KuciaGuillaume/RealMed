import type { RequestHandler } from '@sveltejs/kit';
import { API_URL } from '$env/static/private';

export const GET: RequestHandler = async ({ url }) => {
	try {
    
    console.log("API_CALL: ", "/api/checkUser");

    const username = url.searchParams.get('username');
    if (!username) {
      return new Response(JSON.stringify({ message: 'No username name provided' }), { status: 400 });
    }

		const apiUrl = `${API_URL}/user/check/${username}`;

    console.log("URL: ", apiUrl);

		const res = await fetch(apiUrl, {
			method: 'GET',
		});

    if (res.ok) {
      return new Response(JSON.stringify({ message: 'User exists' }), { status: 200 });
    } else {
      return new Response(JSON.stringify({ message: 'User does not exist' }), { status: 400 });
    } 

	} catch (e) {
    console.error(e);
		return new Response(JSON.stringify({ message: 'Internal server error' }), { status: 500 });
	}
};
