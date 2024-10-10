import type { RequestHandler } from '@sveltejs/kit';

export const POST: RequestHandler = async ({ cookies }) => {
	try {
		cookies.delete('PHPSESSID', { path: '/' });

		return new Response(JSON.stringify({ message: 'Logout successful' }), { status: 200 });
	} catch (e) {
		console.error(e);
		return new Response(JSON.stringify({ message: 'Internal server error' }), { status: 500 });
	}
};