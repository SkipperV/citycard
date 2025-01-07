import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head, Link} from '@inertiajs/react';
import {useTranslation} from "react-i18next";
import {useQuery} from "@tanstack/react-query";
import {useState} from "react";
import TransportRouteElement from "@/Pages/Transport/Partials/TransportRouteElement.jsx";

const retrieveTransports = async (cityId) => {
    const response = await axios.get(route('api.transport.index', {city: cityId}));

    return response.data;
}

export default function Index({auth, city}) {
    const {t} = useTranslation();
    const [deleteButtonsDisabled, setDeleteButtonsDisabled] = useState(false);
    const updateDeleteButtonsDisabled = (newState) => setDeleteButtonsDisabled(newState);

    const {data: transportRoutes, error, isLoading} = useQuery({
        queryKey: ['transportsData', city.id],
        queryFn: () => retrieveTransports(city.id),
    })

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <div className="relative w-full h-6">
                    <Link href={route('cities.index')}>
                        <svg className="absolute left-3 top-1 h-4 text-gray-800 hover:cursor-pointer dark:text-white"
                             aria-hidden="true"
                             xmlns="http://www.w3.org/2000/svg"
                             fill="none"
                             viewBox="0 0 8 14">
                            <path stroke="currentColor" strokeLinecap="round" strokeLinejoin="round" strokeWidth="2"
                                  d="M7 1 1.3 6.326a.91.91 0 0 0 0 1.348L7 13"/>
                        </svg>
                    </Link>
                    <h2 className="absolute left-1/2 transform -translate-x-1/2 top-0 h-full font-semibold text-xl text-gray-800 leading-tight dark:text-gray-300 text-center">
                        {t("transport.title.list")} {city.name}
                    </h2>
                </div>
            }>
            <Head title={`${t("transport.title.list")} ${city.name}`}/>

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    {!isLoading && !error && <div
                        className="relative overflow-x-auto shadow-md sm:rounded-lg rounded dark:border dark:border-gray-600">
                        <table className="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead
                                className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col"
                                    className="px-6 py-3 text-center whitespace-nowrap w-32">{t("transport.table.route_number")}</th>
                                <th scope="col"
                                    className="px-6 py-3 text-center whitespace-nowrap w-64">{t("transport.table.transport_type")}</th>
                                <th scope="colgroup" colSpan="2"
                                    className="pl-6 py-3 text-center whitespace-nowrap w-max">{t("transport.table.endpoints")}</th>
                                <th scope="col"
                                    className="px-6 py-3 text-center whitespace-nowrap w-32">{t("operations.edit")}</th>
                                <th scope="col"
                                    className="px-6 py-3 text-center whitespace-nowrap w-32">{t("operations.delete")}</th>
                            </tr>
                            </thead>
                            <tbody>
                            {transportRoutes.data.map((transportRoute) =>
                                <TransportRouteElement key={transportRoute.id}
                                                       cityId={city.id}
                                                       transportRoute={transportRoute}
                                                       deleteButtonsDisabled={deleteButtonsDisabled}
                                                       updateDeleteButtonsDisabled={updateDeleteButtonsDisabled}/>
                                )}
                            </tbody>
                        </table>
                    </div>}

                    <div className="px-4 py-3">
                        <Link href={route('transport.create', {city: city.id})}
                              className="inline-flex items-center px-4 py-2 bg-white border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow hover:bg-gray-200 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">
                            {t("transport.create_new_route")}
                        </Link>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
