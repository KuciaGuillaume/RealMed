<div class="mt-12 p-2">
    <div class="mx-auto max-w-2xl text-center">
        <h6 class="text-1xl font-bold tracking-tight text-gray-900 sm:text-4xl">
            NOUS CONTACTER
        </h6>
        <!-- <p class="mt-2 text-lg leading-8 text-gray-600">
            Pour toutes questions ou problèmes, n'hésitez pas à nous écrire
        </p> -->
    </div>
    <form action="#" method="POST" class="mx-auto mt-16 max-w-xl sm:mt-20">
        <div class="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-2">
            <div class="sm:col-span-2">
                <label
                    for="email"
                    class="block text-sm font-semibold leading-6 text-gray-900"
                    >Adresse email</label
                >
                <div class="mt-2.5">
                    <input
                        type="email"
                        name="email"
                        id="email"
                        autocomplete="email"
                        class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                    />
                </div>
            </div>

            <div class="sm:col-span-2">
                <label
                    for="message"
                    class="block text-sm font-semibold leading-6 text-gray-900"
                    >Votre message</label
                >
                <div class="mt-2.5">
                    <textarea
                        name="message"
                        id="message"
                        rows="4"
                        class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                    ></textarea>
                </div>
            </div>
        </div>
        <div class="mt-10">
            <button
                type="submit"
                class="block w-full rounded-md bg-indigo-600 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                >Envoyer</button
            >
        </div>
    </form>
</div>
