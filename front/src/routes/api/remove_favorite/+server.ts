import type { RequestHandler } from '@sveltejs/kit';
import { API_URL } from '$env/static/private';

export const POST: RequestHandler = async ({ url, cookies }) => {
  try {
    console.log("API_CALL: ", "/favorite");

    const drugName = url.searchParams.get('drugName');
    if (!drugName) {
      return new Response(JSON.stringify({ message: 'No drug name provided' }), { status: 400 });
    }

    const apiUrl = `${API_URL}/api/medicines/favorite/remove`;

    const formData = new FormData();
    formData.append('name', drugName);

    const PHPSESSID = cookies.get('PHPSESSID');

    const res = await fetch(apiUrl, {
      method: 'POST',
      headers: {
        'Cookie': `PHPSESSID=${PHPSESSID};`,
      },
      body: formData,
    });

    if (res.ok) {
      return new Response(null, { status: 200 });
    } else {
      return new Response(JSON.stringify({ message: 'Failed to remove favorite' }), { status: 400 });
    }

  } catch (e) {
    console.error(e);
    return new Response(JSON.stringify({ message: 'Internal server error' }), { status: 500 });
  }
};