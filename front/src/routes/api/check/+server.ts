import type { RequestHandler } from '@sveltejs/kit';
import { API_URL } from '$env/static/private';

export const GET: RequestHandler = async ({ cookies }) => {
  try {
    console.log("API_CALL: ", "/api/check");

    const url = `${API_URL}/session/check`;

    const PHPSESSID = cookies.get('PHPSESSID');
    
    if (!PHPSESSID) {
      return new Response(JSON.stringify({ message: 'PHPSESSID or AWSALBTGCORS is missing' }), { status: 400 });
    }
    
    const res = await fetch(url, {
      method: 'GET',
      credentials: 'include',
      headers: {
        'Cookie': `PHPSESSID=${PHPSESSID};`,
      },
    });

    if (res.ok) {
      const data = await res.json();
      console.log('Session check result:', data);
      return new Response(JSON.stringify({ message: 'Session is active', data }), { status: 200 });
    } else {
      console.log(await res.text());
      return new Response(JSON.stringify({ message: 'Session is not active' }), { status: 400 });
    }
  } catch (e) {
    console.error(e);
    return new Response(JSON.stringify({ message: 'Internal server error' }), { status: 500 });
  }
};