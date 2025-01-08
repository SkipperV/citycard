import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head, Link} from '@inertiajs/react';
import {useTranslation} from "react-i18next";
import {useQuery, useQueryClient} from "@tanstack/react-query";
import Pagination from "@/Components/Pagination.jsx";
import CityElement from "@/Pages/Cities/Partials/CityElement.jsx";
import {useState} from "react";
import TextInput from "@/Components/TextInput.jsx";
import PrimaryButton from "@/Components/PrimaryButton.jsx";

const retrieveCities = async (page = 1, searchString = '') => {
    const response = await axios.get(route('api.cities.index', {page: page, search: searchString}));

    return response.data;
}

export default function Index({auth}) {
    const {t} = useTranslation();
    const queryClient = useQueryClient();
    const query = new URLSearchParams(window.location.search);

    const [deleteButtonsDisabled, setDeleteButtonsDisabled] = useState(false);
    const [searchString, setSearchString] = useState(query.get('search') || '');
    const [page, setPage] = useState(query.get('page') || '');

    const updateDeleteButtonsDisabled = (newState) => setDeleteButtonsDisabled(newState);
    const handlePageChange = (newPageNumber) => {
        setPage(newPageNumber);
        newPageNumber === 1
            ? query.delete('page')
            : query.set('page', newPageNumber);

        window.history.replaceState({}, '', `${window.location.pathname}${query.size !== 0 ? '?' : ''}${query.toString()}`);
    };

    const {data: cities, error, isLoading} = useQuery({
        queryKey: ['citiesData', page, query.get('search') || ''],
        queryFn: () => retrieveCities(query.get('page') || 1, query.get('search') || ''),
        keepPreviousData: true
    });

    const submitSearch = (e) => {
        e.preventDefault();
        if (searchString) {
            query.set('search', searchString);
            query.delete('page');
        } else {
            query.delete('search');
        }
        window.history.replaceState({}, '', `${window.location.pathname}${query.size !== 0 ? '?' : ''}${query.toString()}`);

        queryClient.invalidateQueries('cities');
    }

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
                    <form onSubmit={submitSearch}
                          className="mb-4">
                        <TextInput
                            placeholder={t('cities.search_placeholder')}
                            value={searchString}
                            onChange={(e) => setSearchString(e.target.value)}
                            className="border p-2 rounded"
                        />
                        <PrimaryButton type="submit" className="ml-2 px-4 py-2 bg-blue-500 text-white rounded">
                            {t('operations.search')}
                        </PrimaryButton>
                    </form>
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
                            {cities.last_page !== 1 &&
                                <Pagination links={cities.links} handlePageChange={handlePageChange}/>}
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
