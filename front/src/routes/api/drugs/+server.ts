import type { RequestHandler } from '@sveltejs/kit';
import { API_URL } from '$env/static/private';

export const GET: RequestHandler = async ({ request, cookies }) => {
  try {

    console.log("API_CALL: ", "/drugs");

    const url = `${API_URL}/api/medicines`;

    const PHPSESSID = cookies.get('PHPSESSID');

    const res = await fetch(url, {
      method: 'GET',
      headers: {
        'Cookie': `PHPSESSID=${PHPSESSID};`,
      },
    });

    const bodyText = await res.text();
    console.log('bodyText:', bodyText);

    if (res.ok) {
      const data = JSON.parse(bodyText);
      return new Response(JSON.stringify(data), { status: 200 });
    } else {
      console.error("Error fetching medicines:", bodyText);
      return new Response(JSON.stringify({ message: 'Failed to fetch drugs' }), { status: 400 });
    }

  } catch (e) {
    console.error(e);
    return new Response(JSON.stringify({ message: 'Internal server error' }), { status: 500 });
  }
};