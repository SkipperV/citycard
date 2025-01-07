import {Link} from "@inertiajs/react";
import {useTranslation} from "react-i18next";

export default function Card({card}) {
    const {t} = useTranslation();

    return (
        <div
            className="border border-gray-200 bg-gray-50 p-10 rounded min-w-fit max-w-lg mx-auto mb-12 dark:border-gray-600 dark:bg-gray-800">
            <h2 className="mb-1 block font-medium text-xl text-gray-700 dark:text-gray-200">
                {t(`tickets.type.${card.type}`)} {t('home.cards.name')}
            </h2>

            <p className="text-gray-700 dark:text-gray-200">{card.number}</p>
            <div className="flex mt-2 text-center text-gray-700 dark:text-gray-200">
                <p className="text-xl">
                    {card.current_balance}
                </p>
                <sup className="text-sm"> UAH</sup>
            </div>

            <div className="flex justify-between">
                <Link className="font-medium text-blue-600 dark:text-blue-500 hover:underline pr-12"
                      href={route('cards.transactions.index', {'card': card.id, 'type': 'outcomes'})}>
                    {t('home.cards.payments_history')}
                </Link>

                <Link className="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                      href={route('cards.transactions.index', {'card': card.id, 'type': 'incomes'})}>
                    {t('home.cards.top_ups_history')}
                </Link>
            </div>
        </div>
    );
}
