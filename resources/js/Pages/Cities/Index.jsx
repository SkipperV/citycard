import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head, Link} from '@inertiajs/react';
import {useTranslation} from "react-i18next";
import {useQuery} from "@tanstack/react-query";
import Pagination from "@/Components/Pagination.jsx";
import CityElement from "@/Pages/Cities/Partials/CityElement.jsx";
import {useState} from "react";

const retrieveCities = async (page = 1) => {
    const response = await axios.get(route('api.cities.index', {page: page}));

    return response.data;
}

export default function Index({auth, page}) {
    const {t} = useTranslation();
    const [deleteButtonsDisabled, setDeleteButtonsDisabled] = useState(false);
    const updateDeleteButtonsDisabled = (newState) => setDeleteButtonsDisabled(newState);

    const {data: cities, error, isLoading} = useQuery({
        queryKey: ['citiesData', page],
        queryFn: () => retrieveCities(page),
        keepPreviousData: true
    })

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight dark:text-gray-300 text-center">
                    {t('cities.title.list')}
                </h2>
            }>
            <Head title={t('cities.title.list')}/>

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    {!isLoading && !error &&
                        <div
                            className="relative overflow-x-auto shadow-md sm:rounded-lg rounded dark:border dark:border-gray-600">
                            <table className="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <thead
                                    className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col"
                                        className="px-6 py-3 whitespace-nowrap w-max">{t('cities.table.city_and_region')}</th>
                                    <th scope="col"
                                        className="px-6 py-3 text-center whitespace-nowrap w-48">{t('cities.table.transport')}</th>
                                    <th scope="col"
                                        className="px-6 py-3 text-center whitespace-nowrap w-48">{t('cities.table.tickets')}</th>
                                    <th scope="col"
                                        className="px-6 py-3 text-center whitespace-nowrap w-32">{t('operations.edit')}</th>
                                    <th scope="col"
                                        className="px-6 py-3 text-center whitespace-nowrap w-32">{t('operations.delete')}</th>
                                </tr>
                                </thead>
                                <tbody>
                                {cities.data.map((city) =>
                                    <CityElement key={city.id}
                                                 city={city}
                                                 deleteButtonsDisabled={deleteButtonsDisabled}
                                                 updateDeleteButtonsDisabled={updateDeleteButtonsDisabled}/>
                                )}
                                </tbody>
                            </table>
                            {cities.last_page !== 1 && <Pagination links={cities.links}/>}
                        </div>
                    }
                    <div className="px-4 py-3">
                        <Link href={route('cities.create')}
                              className="inline-flex items-center px-4 py-2 bg-white border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow hover:bg-gray-200 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">
                            {t('cities.create_new_city')}
                        </Link>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
