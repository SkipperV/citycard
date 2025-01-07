import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.jsx";
import {Head, Link} from "@inertiajs/react";
import TransactionsTable from "@/Pages/TransactionsHistory/Partials/TransactionsTable.jsx";
import {useTranslation} from "react-i18next";
import {useQuery} from "@tanstack/react-query";

const retrieveTransactionsHistory = async (transactionsType, cardId, page) => {
    const response = await axios.get(route('api.user.cards.transactions.' + transactionsType, {card: cardId, page: page}));

    return response.data;
}

export default function Index({auth, cardId, transactionsType, page}) {
    const {t} = useTranslation();
    const {data: transactionsHistory, error, isLoading} = useQuery({
        queryKey: ['transactionsHistoryData', cardId, transactionsType, page],
        queryFn: () => retrieveTransactionsHistory(transactionsType, cardId, page),
    })

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <div className="relative w-full h-6">
                    <Link href={route('user.home.index')}>
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
                        {t('transactions_history.title')}
                    </h2>
                </div>
            }>
            <Head title={t('transactions_history.title')}/>

            {transactionsType === 'incomes' ? (
                <div className="mx-auto max-w-7xl grid grid-cols-2 my-4 px-4 h-12">
                    <Link
                        className="flex w-3/4 justify-center items-center ml-auto rounded-l bg-gray-100 border hover:bg-white shadow-md text-gray-800 dark:bg-gray-900 dark:text-gray-300 dark:hover:bg-gray-800 dark:border-gray-600"
                        href={route('cards.transactions.index', {'card': cardId, 'type': 'outcomes'})}>
                        {t('transactions_history.type.payments')}
                    </Link>
                    <div
                        className="flex w-3/4 rounded-r bg-white border shadow-md dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
                        <p className="m-auto">
                            {t('transactions_history.type.top_ups')}
                        </p>
                    </div>
                </div>
            ) : (
                <div className="mx-auto max-w-7xl grid grid-cols-2 my-4 px-4 h-12">
                    <div
                        className="flex ml-auto w-3/4 rounded-l bg-white border shadow-md dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
                        <p className="m-auto">
                            {t('transactions_history.type.payments')}
                        </p>
                    </div>
                    <Link
                        className="flex w-3/4 justify-center items-center rounded-r bg-gray-100 border hover:bg-white shadow-md text-gray-800 dark:bg-gray-900 dark:text-gray-300 dark:hover:bg-gray-800 dark:border-gray-600"
                        href={route('cards.transactions.index', {'card': cardId, 'type': 'incomes'})}>
                        {t('transactions_history.type.top_ups')}
                    </Link>
                </div>
            )}

            <div className="mt-4 max-w-xl mx-auto pb-24">
                {!isLoading && !error && <TransactionsTable transactions={transactionsHistory.transactions}/>}
            </div>
        </AuthenticatedLayout>
    );
}
