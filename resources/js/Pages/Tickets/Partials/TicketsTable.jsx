import {Link, router} from "@inertiajs/react";
import {useTranslation} from "react-i18next";

export default function TicketsTable({tickets, cityId}) {
    const {t} = useTranslation()

    const deleteTicket = (id) => {
        router.delete(route('tickets.destroy', [cityId, id]));
    }

    return (
        <div className="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table className="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" className="px-6 py-3">{t("tickets.table.transport_type")}</th>
                    <th scope="col" className="px-6 py-3">{t("tickets.table.ticket_type")}</th>
                    <th scope="col" className="px-6 py-3">{t("tickets.table.price")}</th>
                    <th scope="col" className="px-6 py-3">{t("operations.edit")}</th>
                    <th scope="col" className="px-6 py-3">{t("operations.delete")}</th>
                </tr>
                </thead>
                <tbody>
                {tickets.map((ticket) =>
                    <tr key={ticket.id} className="bg-white border-t dark:bg-gray-900 dark:border-gray-700">
                        <td scope="col" className="px-6 py-4">
                            {t(`transport.type.${ticket.transport_type}`)}
                        </td>
                        <td scope="col" className="px-6 py-4">
                            {t(`tickets.type.${ticket.ticket_type}`)}
                        </td>
                        <td scope="col" className="px-6 py-4">
                            {ticket.price}
                        </td>
                        <td className="px-6 py-4">
                            <Link href={route('tickets.edit', [cityId, ticket.id])}
                                  className="font-xmedium text-green-700 dark:text-green-600 hover:underline">
                                {t(`operations.edit`)}

                            </Link>
                        </td>
                        <td scope="col" className="px-6 py-4">
                            <button onClick={() => deleteTicket(ticket.id)} className="text-red-600 font-medium">
                                {t(`operations.delete`)}
                            </button>
                        </td>
                    </tr>
                )}
                </tbody>
            </table>
        </div>
    );
}
