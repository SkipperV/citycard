import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head, Link} from '@inertiajs/react';
import {useTranslation} from "react-i18next";
import {useQuery} from "@tanstack/react-query";
import {useState} from "react";
import TicketElement from "@/Pages/Tickets/Partials/TicketElement.jsx";

const retrieveTickets = async (cityId) => {
    const response = await axios.get(route('api.tickets.index', {city: cityId}));

    return response.data;
}

export default function Index({auth, city}) {
    const {t} = useTranslation();
    const [deleteButtonsDisabled, setDeleteButtonsDisabled] = useState(false);
    const updateDeleteButtonsDisabled = (newState) => setDeleteButtonsDisabled(newState);

    const {data: tickets, error, isLoading} = useQuery({
        queryKey: ['ticketsData', city.id],
        queryFn: () => retrieveTickets(city.id)
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
                        {t('tickets.title.list')} {city.name}
                    </h2>
                </div>
            }>
            <Head title={`${t('tickets.title.list')} ${city.name}`}/>

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    {!isLoading && !error && <div
                        className="relative overflow-x-auto shadow-md sm:rounded-lg rounded dark:border dark:border-gray-600">
                        <table className="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead
                                className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col"
                                    className="px-6 py-3 whitespace-nowrap">{t('tickets.table.transport_type')}</th>
                                <th scope="col"
                                    className="px-6 py-3 whitespace-nowrap text-center">{t('tickets.table.ticket_type')}</th>
                                <th scope="col"
                                    className="px-6 py-3 whitespace-nowrap w-32 text-center">{t('tickets.table.price')}</th>
                                <th scope="col"
                                    className="px-6 py-3 whitespace-nowrap w-32 text-center">{t('operations.edit')}</th>
                                <th scope="col"
                                    className="px-6 py-3 whitespace-nowrap w-32 text-center">{t('operations.delete')}</th>
                            </tr>
                            </thead>
                            <tbody>
                            {tickets.data.map((ticket) =>
                                <TicketElement key={ticket.id}
                                               cityId={city.id}
                                               ticket={ticket}
                                               deleteButtonsDisabled={deleteButtonsDisabled}
                                               updateDeleteButtonsDisabled={updateDeleteButtonsDisabled}/>
                            )}
                            </tbody>
                        </table>
                    </div>
                    }

                    <div className="px-4 py-3">
                        <Link href={route('tickets.create', {city: city.id})}
                              className="inline-flex items-center px-4 py-2 bg-white border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow hover:bg-gray-200 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">
                            {t('tickets.create_new_ticket')}
                        </Link>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
