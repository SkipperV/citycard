import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.jsx";
import {Head, Link, router} from "@inertiajs/react";
import TransactionsTable from "@/Pages/TransactionsHistory/Partials/TransactionsTable.jsx";

export default function Index({auth, card, transactionsType, transactions}) {
    const isTransactionsEmpty = !transactions.length

    const handleRedirect = () => {
        router.visit(route('user.home.index'));
    }

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <div className="relative w-full h-6">
                    <svg onClick={handleRedirect}
                         className="absolute left-3 top-1 h-4 text-gray-800 hover:cursor-pointer dark:text-white"
                         aria-hidden="true"
                         xmlns="http://www.w3.org/2000/svg"
                         fill="none"
                         viewBox="0 0 8 14">
                        <path stroke="currentColor" strokeLinecap="round" strokeLinejoin="round" strokeWidth="2"
                              d="M7 1 1.3 6.326a.91.91 0 0 0 0 1.348L7 13"/>
                    </svg>
                    <h2 className="absolute left-1/2 transform -translate-x-1/2 top-0 h-full font-semibold text-xl text-gray-800 leading-tight dark:text-gray-300 text-center">
                        Історія транзакцій
                    </h2>
                </div>
            }>
            <Head title="Історія транзакцій"/>

            {transactionsType ? (
                <div className="mx-auto max-w-7xl grid grid-cols-2 my-4 px-4 h-12">
                    <Link
                        className="flex w-3/4 justify-center items-center ml-auto rounded-l bg-gray-100 border hover:bg-white shadow-md text-gray-800 dark:bg-gray-900 dark:text-gray-300 dark:hover:bg-gray-800 dark:border-gray-600"
                        href={route('cards.transactions.index', {'card': card.id, 'type': 'outcome'})}>
                        Переглянути історію використання картки (історію поїздок)
                    </Link>
                    <div
                        className="flex w-3/4 rounded-r bg-white border shadow-md dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
                        <p className="m-auto">
                            Історія поповнення картки
                        </p>
                    </div>
                </div>
            ) : (
                <div className="mx-auto max-w-7xl grid grid-cols-2 my-4 px-4 h-12">
                    <div
                        className="flex ml-auto w-3/4 rounded-l bg-white border shadow-md dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
                        <p className="m-auto">
                            Історія використання картки (історія поїздок)
                        </p>
                    </div>
                    <Link
                        className="flex w-3/4 justify-center items-center rounded-r bg-gray-100 border hover:bg-white shadow-md text-gray-800 dark:bg-gray-900 dark:text-gray-300 dark:hover:bg-gray-800 dark:border-gray-600"
                        href={route('cards.transactions.index', {'card': card.id, 'type': 'income'})}>
                        Переглянути сторію поповнення картки
                    </Link>
                </div>
            )}

            {!isTransactionsEmpty ? (
                <div className="mt-4 max-w-xl mx-auto">
                    <TransactionsTable transactions={transactions}/>
                </div>
            ) : (
                <div
                    className="flex mx-auto max-w-xl text-center h-16 rounded-l bg-white border shadow-md dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300">
                    <p className="m-auto text-xl">
                        Немає записів недавніх транзакцій
                    </p>
                </div>
            )}
        </AuthenticatedLayout>
    );
}
