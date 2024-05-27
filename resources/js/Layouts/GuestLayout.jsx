import {Link} from '@inertiajs/react';

export default function Guest({children}) {
    return (
        <div className="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
            <div className="text-6xl mb-8">
                <Link href="/">
                    <h1 className="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200">Citycard</h1>
                </Link>
            </div>

            <div
                className="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg dark:bg-gray-800">
                {children}
            </div>
        </div>
    );
}
