import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head, Link} from '@inertiajs/react';
import CitiesTable from "@/Pages/Cities/Partials/CitiesTable.jsx";
import {useTranslation} from "react-i18next";

export default function Index({auth, cities}) {
    const {t} = useTranslation()

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight dark:text-gray-300 text-center">
                    {t(`cities.title.list`)}
                </h2>
            }>
            <Head title={t(`cities.title.list`)}/>

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <CitiesTable cities={cities}/>
                    <div className="px-4 py-3">
                        <Link href={route("cities.create")}
                              className="inline-flex items-center px-4 py-2 bg-white border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow hover:bg-gray-200 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">
                            {t(`cities.create_new_city`)}
                        </Link>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
