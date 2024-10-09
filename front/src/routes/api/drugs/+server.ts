import type { RequestHandler } from '@sveltejs/kit';
import { API_URL } from '$env/static/private';

export const GET: RequestHandler = async ({ request }) => {
  try {

    console.log("API_CALL: ", "/drugs");

    const url = `${API_URL}/api/medicines`;

    const res = await fetch(url, {
      method: 'GET',
    });

    const bodyText = await res.text();

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