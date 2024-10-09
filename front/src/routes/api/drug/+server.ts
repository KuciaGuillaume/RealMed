import type { RequestHandler } from '@sveltejs/kit';
import { API_URL } from '$env/static/private';

export const GET: RequestHandler = async ({ url }) => {
  try {
    console.log("API_CALL: ", "/drug");

    const drugName = url.searchParams.get('drugName');
    if (!drugName) {
      return new Response(JSON.stringify({ message: 'No drug name provided' }), { status: 400 });
    }

    const apiUrl = `${API_URL}/api/medicines/${encodeURIComponent(drugName)}`;

    console.log("URL: ", apiUrl);

    const res = await fetch(apiUrl, {
      method: 'GET',
    });

    const bodyText = await res.text();

    if (res.ok) {
      const data = JSON.parse(bodyText);
      return new Response(JSON.stringify(data), { status: 200 });
    } else {
      console.error("Error fetching medicines:", bodyText);
      return new Response(JSON.stringify({ message: 'Failed to fetch drug' }), { status: 400 });
    }

  } catch (e) {
    console.error(e);
    return new Response(JSON.stringify({ message: 'Internal server error' }), { status: 500 });
  }
};