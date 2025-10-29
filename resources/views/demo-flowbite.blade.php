<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Flowbite Component Showcase - {{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white border-b border-gray-200 px-4 py-3">
        <div class="max-w-7xl mx-auto flex flex-wrap items-center justify-between">
            <a href="#" class="flex items-center space-x-3">
                <span class="text-2xl font-bold text-blue-600">Flowbite Showcase</span>
            </a>
            <div class="flex items-center space-x-4">
                <a href="#" class="text-gray-700 hover:text-blue-600">Components</a>
                <a href="#" class="text-gray-700 hover:text-blue-600">Documentation</a>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-8 text-center">
            <h1 class="text-4xl font-bold text-gray-900 mb-2">Flowbite Component Showcase</h1>
            <p class="text-gray-600">Explore all available Flowbite components and see how they look</p>
        </div>

        <!-- Breadcrumbs -->
        <section class="mb-12">
            <div class="flex items-center mb-4">
                <h2 class="text-2xl font-bold mr-4">Breadcrumbs</h2>
            </div>
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="#" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">Home</a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <a href="#" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">Components</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Showcase</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </section>

        <!-- Alerts -->
        <section class="mb-12 bg-white p-6 rounded-lg shadow">
            <h2 class="text-2xl font-bold mb-4">Alerts</h2>
            <div class="space-y-4">
                <div class="p-4 text-sm text-blue-800 rounded-lg bg-blue-50" role="alert">
                    <span class="font-medium">Info alert!</span> This is an informational message.
                </div>
                <div class="p-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
                    <span class="font-medium">Success alert!</span> Operation completed successfully.
                </div>
                <div class="p-4 text-sm text-yellow-800 rounded-lg bg-yellow-50" role="alert">
                    <span class="font-medium">Warning alert!</span> Please review this information.
                </div>
                <div class="p-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
                    <span class="font-medium">Danger alert!</span> An error occurred.
                </div>
            </div>
        </section>

        <!-- Buttons -->
        <section class="mb-12 bg-white p-6 rounded-lg shadow">
            <h2 class="text-2xl font-bold mb-4">Buttons</h2>
            <div class="flex flex-wrap gap-4">
                <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">Default</button>
                <button type="button" class="py-2.5 px-5 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">Alternative</button>
                <button type="button" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5">Success</button>
                <button type="button" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5">Danger</button>
                <button type="button" class="text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5">Warning</button>
                <button type="button" class="text-gray-900 bg-white border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5">Light</button>
                <button type="button" class="text-white bg-gray-800 hover:bg-gray-900 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5">Dark</button>
            </div>
            
            <div class="mt-4">
                <h3 class="text-lg font-semibold mb-2">Button Sizes</h3>
                <div class="flex flex-wrap gap-4 items-center">
                    <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-xs px-3 py-1.5">Extra small</button>
                    <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2">Small</button>
                    <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">Base</button>
                    <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-base px-6 py-3">Large</button>
                </div>
            </div>
        </section>

        <!-- Badges -->
        <section class="mb-12 bg-white p-6 rounded-lg shadow">
            <h2 class="text-2xl font-bold mb-4">Badges</h2>
            <div class="flex flex-wrap gap-3 items-center">
                <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">Default</span>
                <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded">Success</span>
                <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2.5 py-0.5 rounded">Warning</span>
                <span class="bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded">Danger</span>
                <span class="bg-indigo-100 text-indigo-800 text-xs font-semibold px-2.5 py-0.5 rounded">Indigo</span>
                <span class="bg-purple-100 text-purple-800 text-xs font-semibold px-2.5 py-0.5 rounded">Purple</span>
                <span class="bg-pink-100 text-pink-800 text-xs font-semibold px-2.5 py-0.5 rounded">Pink</span>
            </div>
            <div class="mt-4">
                <h3 class="text-lg font-semibold mb-2">Sizes</h3>
                <div class="flex flex-wrap gap-3 items-center">
                    <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-0.5 rounded">Small</span>
                    <span class="bg-blue-100 text-blue-800 text-sm font-semibold px-2.5 py-0.5 rounded">Default</span>
                    <span class="bg-blue-100 text-blue-800 text-base font-semibold px-3 py-1 rounded">Large</span>
                </div>
            </div>
        </section>

        <!-- Progress Bars -->
        <section class="mb-12 bg-white p-6 rounded-lg shadow">
            <h2 class="text-2xl font-bold mb-4">Progress Bars</h2>
            <div class="space-y-4">
                <div class="w-full bg-gray-200 rounded-full h-2.5">
                    <div class="bg-blue-600 h-2.5 rounded-full" style="width: 45%"></div>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2.5">
                    <div class="bg-green-600 h-2.5 rounded-full" style="width: 60%"></div>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2.5">
                    <div class="bg-yellow-600 h-2.5 rounded-full" style="width: 75%"></div>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2.5">
                    <div class="bg-red-600 h-2.5 rounded-full" style="width: 90%"></div>
                </div>
            </div>
        </section>

        <!-- Spinners -->
        <section class="mb-12 bg-white p-6 rounded-lg shadow">
            <h2 class="text-2xl font-bold mb-4">Spinners</h2>
            <div class="flex flex-wrap gap-6 items-center">
                <div role="status">
                    <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                    </svg>
                    <span class="sr-only">Loading...</span>
                </div>
                <div role="status">
                    <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin fill-green-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                    </svg>
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </section>

        <!-- Cards -->
        <section class="mb-12">
            <h2 class="text-2xl font-bold mb-4">Cards</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow">
                    <div class="p-5">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">Card Title</h5>
                        <p class="mb-3 font-normal text-gray-700">This is a card component from Flowbite with title and description.</p>
                        <a href="#" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800">
                            Read more
                            <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                            </svg>
                        </a>
                    </div>
                </div>
                
                <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow">
                    <a href="#">
                        <img class="rounded-t-lg" src="https://flowbite.com/docs/images/blog/image-1.jpg" alt="" />
                    </a>
                    <div class="p-5">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">Card with Image</h5>
                        <p class="mb-3 font-normal text-gray-700">Card component with an image on top and content below.</p>
                        <a href="#" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800">
                            Read more
                        </a>
                    </div>
                </div>
                
                <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow">
                    <div class="p-5">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">Card with Footer</h5>
                        <p class="mb-3 font-normal text-gray-700">Card component with footer section.</p>
                        <div class="flex items-center justify-between pt-4">
                            <span class="text-sm text-gray-500">Published</span>
                            <a href="#" class="text-sm font-medium text-blue-600 hover:underline">View</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Forms -->
        <section class="mb-12 bg-white p-6 rounded-lg shadow">
            <h2 class="text-2xl font-bold mb-4">Forms</h2>
            <form class="space-y-6 max-w-2xl">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="firstName" class="block mb-2 text-sm font-medium text-gray-900">First Name</label>
                        <input type="text" id="firstName" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="John" required>
                    </div>
                    <div>
                        <label for="lastName" class="block mb-2 text-sm font-medium text-gray-900">Last Name</label>
                        <input type="text" id="lastName" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Doe" required>
                    </div>
                </div>
                
                <div>
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                    <input type="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="name@company.com" required>
                </div>
                
                <div>
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password</label>
                    <input type="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                </div>
                
                <div>
                    <label for="countries" class="block mb-2 text-sm font-medium text-gray-900">Country</label>
                    <select id="countries" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        <option selected>Choose a country</option>
                        <option value="US">United States</option>
                        <option value="CA">Canada</option>
                        <option value="FR">France</option>
                        <option value="DE">Germany</option>
                    </select>
                </div>
                
                <div>
                    <label for="message" class="block mb-2 text-sm font-medium text-gray-900">Message</label>
                    <textarea id="message" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Write your message here..."></textarea>
                </div>
                
                <div class="flex items-center">
                    <input id="remember" type="checkbox" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300">
                    <label for="remember" class="ms-2 text-sm font-medium text-gray-900">Remember me</label>
                </div>
                
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Submit</button>
            </form>
        </section>

        <!-- Tables -->
        <section class="mb-12 bg-white p-6 rounded-lg shadow">
            <h2 class="text-2xl font-bold mb-4">Tables</h2>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">Product name</th>
                            <th scope="col" class="px-6 py-3">Color</th>
                            <th scope="col" class="px-6 py-3">Category</th>
                            <th scope="col" class="px-6 py-3">Price</th>
                            <th scope="col" class="px-6 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">Apple MacBook Pro 17"</td>
                            <td class="px-6 py-4">Silver</td>
                            <td class="px-6 py-4">Laptop</td>
                            <td class="px-6 py-4">$2999</td>
                            <td class="px-6 py-4">
                                <a href="#" class="font-medium text-blue-600 hover:underline">Edit</a>
                            </td>
                        </tr>
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">Microsoft Surface Pro</td>
                            <td class="px-6 py-4">White</td>
                            <td class="px-6 py-4">Laptop PC</td>
                            <td class="px-6 py-4">$1999</td>
                            <td class="px-6 py-4">
                                <a href="#" class="font-medium text-blue-600 hover:underline">Edit</a>
                            </td>
                        </tr>
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">Magic Mouse 2</td>
                            <td class="px-6 py-4">Black</td>
                            <td class="px-6 py-4">Accessories</td>
                            <td class="px-6 py-4">$99</td>
                            <td class="px-6 py-4">
                                <a href="#" class="font-medium text-blue-600 hover:underline">Edit</a>
                            </td>
                        </tr>
                        <tr class="bg-white hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">Apple Watch</td>
                            <td class="px-6 py-4">Silver</td>
                            <td class="px-6 py-4">Wearables</td>
                            <td class="px-6 py-4">$399</td>
                            <td class="px-6 py-4">
                                <a href="#" class="font-medium text-blue-600 hover:underline">Edit</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Pagination -->
        <section class="mb-12 bg-white p-6 rounded-lg shadow">
            <h2 class="text-2xl font-bold mb-4">Pagination</h2>
            <nav aria-label="Page navigation example">
                <ul class="inline-flex -space-x-px text-sm">
                    <li>
                        <a href="#" class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700">Previous</a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700">1</a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700">2</a>
                    </li>
                    <li>
                        <a href="#" aria-current="page" class="flex items-center justify-center px-3 h-8 text-blue-600 border border-gray-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700">3</a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700">4</a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700">5</a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700">Next</a>
                    </li>
                </ul>
            </nav>
        </section>

        <!-- Dropdowns -->
        <section class="mb-12 bg-white p-6 rounded-lg shadow">
            <h2 class="text-2xl font-bold mb-4">Dropdowns</h2>
            <div class="flex gap-4 flex-wrap">
                <button id="dropdownButton" data-dropdown-toggle="dropdown" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center" type="button">
                    Dropdown button
                    <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                    </svg>
                </button>
                <div id="dropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
                    <ul class="py-2 text-sm text-gray-700">
                        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Dashboard</a></li>
                        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Settings</a></li>
                        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Earnings</a></li>
                        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Sign out</a></li>
                    </ul>
                </div>

                <button id="dropdownHoverButton" data-dropdown-toggle="dropdownHover" data-dropdown-trigger="hover" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center" type="button">
                    Hover dropdown
                    <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                    </svg>
                </button>
                <div id="dropdownHover" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
                    <ul class="py-2 text-sm text-gray-700">
                        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Dashboard</a></li>
                        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Settings</a></li>
                        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Sign out</a></li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- Tooltips -->
        <section class="mb-12 bg-white p-6 rounded-lg shadow">
            <h2 class="text-2xl font-bold mb-4">Tooltips</h2>
            <div class="flex gap-4">
                <button data-tooltip-target="tooltip-default" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    Default tooltip
                </button>
                <div id="tooltip-default" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip">
                    Tooltip content
                    <div class="tooltip-arrow" data-popper-arrow></div>
                </div>

                <button data-tooltip-target="tooltip-top" data-tooltip-placement="top" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    Top tooltip
                </button>
                <div id="tooltip-top" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip">
                    Tooltip on top
                    <div class="tooltip-arrow" data-popper-arrow></div>
                </div>
            </div>
        </section>

        <!-- Modals -->
        <section class="mb-12 bg-white p-6 rounded-lg shadow">
            <h2 class="text-2xl font-bold mb-4">Modals</h2>
            <button data-modal-target="default-modal" data-modal-toggle="default-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center" type="button">
                Launch modal
            </button>
            
            <div id="default-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-2xl max-h-full">
                    <div class="relative bg-white rounded-lg shadow">
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                            <h3 class="text-xl font-semibold text-gray-900">
                                Modal title
                            </h3>
                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="default-modal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <div class="p-4 md:p-5 space-y-4">
                            <p class="text-base leading-relaxed text-gray-500">
                                This is a modal dialog example from Flowbite. You can add any content here.
                            </p>
                        </div>
                        <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b">
                            <button data-modal-hide="default-modal" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">I accept</button>
                            <button data-modal-hide="default-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:z-10 focus:ring-4 focus:ring-gray-100">Decline</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Accordion -->
        <section class="mb-12 bg-white p-6 rounded-lg shadow">
            <h2 class="text-2xl font-bold mb-4">Accordion</h2>
            <div id="accordion-collapse" data-accordion="collapse">
                <h2 id="accordion-collapse-heading-1">
                    <button type="button" class="flex items-center justify-between w-full p-5 rtl:text-right text-gray-500 border border-b-0 border-gray-200 rounded-t-xl focus:ring-4 focus:ring-gray-200" data-accordion-target="#accordion-collapse-body-1" aria-expanded="true" aria-controls="accordion-collapse-body-1">
                        <span>What is Flowbite?</span>
                        <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                        </svg>
                    </button>
                </h2>
                <div id="accordion-collapse-body-1" class="hidden" aria-labelledby="accordion-collapse-heading-1">
                    <div class="p-5 border border-b-0 border-gray-200">
                        <p class="mb-2 text-gray-500">Flowbite is an open-source library of interactive components built on top of Tailwind CSS.</p>
                    </div>
                </div>
                <h2 id="accordion-collapse-heading-2">
                    <button type="button" class="flex items-center justify-between w-full p-5 rtl:text-right text-gray-500 border border-b-0 border-gray-200 focus:ring-4 focus:ring-gray-200" data-accordion-target="#accordion-collapse-body-2" aria-expanded="false" aria-controls="accordion-collapse-body-2">
                        <span>Is there a Figma file available?</span>
                        <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                        </svg>
                    </button>
                </h2>
                <div id="accordion-collapse-body-2" class="hidden" aria-labelledby="accordion-collapse-heading-2">
                    <div class="p-5 border border-b-0 border-gray-200">
                        <p class="mb-2 text-gray-500">Yes, Flowbite provides a Figma design system file.</p>
                    </div>
                </div>
                <h2 id="accordion-collapse-heading-3">
                    <button type="button" class="flex items-center justify-between w-full p-5 rtl:text-right text-gray-500 border border-gray-200 rounded-b-xl focus:ring-4 focus:ring-gray-200" data-accordion-target="#accordion-collapse-body-3" aria-expanded="false" aria-controls="accordion-collapse-body-3">
                        <span>What are the differences between Flowbite and Tailwind UI?</span>
                        <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                        </svg>
                    </button>
                </h2>
                <div id="accordion-collapse-body-3" class="hidden" aria-labelledby="accordion-collapse-heading-3">
                    <div class="p-5 border border-t-0 border-gray-200 rounded-b-xl">
                        <p class="mb-2 text-gray-500">Flowbite is open-source and free, while Tailwind UI is a paid product.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Tabs -->
        <section class="mb-12 bg-white p-6 rounded-lg shadow">
            <h2 class="text-2xl font-bold mb-4">Tabs</h2>
            <ul class="flex flex-wrap text-sm font-medium text-center text-gray-500 border-b border-gray-200">
                <li class="me-2">
                    <a href="#" class="inline-block p-4 text-blue-600 border-b-2 border-blue-600 rounded-t-lg active" aria-current="page">Profile</a>
                </li>
                <li class="me-2">
                    <a href="#" class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300">Dashboard</a>
                </li>
                <li class="me-2">
                    <a href="#" class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300">Settings</a>
                </li>
                <li class="me-2">
                    <a href="#" class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300">Contacts</a>
                </li>
            </ul>
        </section>

        <!-- List Groups -->
        <section class="mb-12 bg-white p-6 rounded-lg shadow">
            <h2 class="text-2xl font-bold mb-4">List Groups</h2>
            <div class="max-w-md">
                <ul class="w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg">
                    <li class="w-full px-4 py-2 border-b border-gray-200 rounded-t-lg">
                        Profile
                    </li>
                    <li class="w-full px-4 py-2 border-b border-gray-200">
                        Settings
                    </li>
                    <li class="w-full px-4 py-2 border-b border-gray-200">
                        Messages
                    </li>
                    <li class="w-full px-4 py-2 rounded-b-lg">
                        Download
                    </li>
                </ul>
            </div>
        </section>
    </div>

    <!-- Flowbite JS -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite/dist/flowbite.min.js"></script>
</body>
</html>
