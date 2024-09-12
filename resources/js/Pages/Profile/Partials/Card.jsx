import {Link} from "@inertiajs/react";

export default function Card({card}) {
    return (
        <div className="border border-gray-200 bg-gray-50 p-10 rounded min-w-fit max-w-lg mx-auto mb-12 dark:border-gray-600 dark:bg-gray-800">
            <h2 className="mb-1 block font-medium text-xl text-gray-700 dark:text-gray-200">
                {card.type} проїзний квиток (картка)
            </h2>

            <p className="text-gray-700 dark:text-gray-200">{card.number}</p>
            <div className="flex mt-2 text-center text-gray-700 dark:text-gray-200">
            <p className="text-xl">
                {card.current_balance}
            </p>
                <sup className="text-sm"> UAH</sup>
            </div>

            <div className="flex justify-between">
                <Link className="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                   href={route('cards.transactions.index', {'card': card.id, 'type': 'outcome'})}>
                    Історія поїздок
                </Link>

                <Link className="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                   href={route('cards.transactions.index', {'card': card.id, 'type': 'income'})}>
                    Історія поповнень
                </Link>
            </div>
        </div>
    );
}
