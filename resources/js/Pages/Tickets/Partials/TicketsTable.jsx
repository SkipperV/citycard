import {Link} from "@inertiajs/react";
import {useTranslation} from "react-i18next";
import {useMutation, useQueryClient} from "@tanstack/react-query";

export default function TicketsTable({tickets, cityId}) {
    const {t} = useTranslation();
    const queryClient = useQueryClient();

    const mutation = useMutation({
        mutationFn: async ({ticketId}) => {
            return await axios.delete(route('api.tickets.destroy', {city: cityId, ticket: ticketId}));
        },
        onSuccess: () => {
            queryClient.invalidateQueries('ticketsData');
        },
        onError: (error) => {
            console.error('Error deleting ticket:', error);
        }
    });

    const deleteTicket = (ticketId) => {
        mutation.mutate({ticketId});
    }

    return (
        <div className="relative overflow-x-auto shadow-md sm:rounded-lg rounded dark:border dark:border-gray-600">
            <table className="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col"
                        className="px-6 py-3 whitespace-nowrap">{t("tickets.table.transport_type")}</th>
                    <th scope="col"
                        className="px-6 py-3 whitespace-nowrap text-center">{t("tickets.table.ticket_type")}</th>
                    <th scope="col"
                        className="px-6 py-3 whitespace-nowrap w-32 text-center">{t("tickets.table.price")}</th>
                    <th scope="col"
                        className="px-6 py-3 whitespace-nowrap w-32 text-center">{t("operations.edit")}</th>
                    <th scope="col"
                        className="px-6 py-3 whitespace-nowrap w-32 text-center">{t("operations.delete")}</th>
                </tr>
                </thead>
                <tbody>
                {tickets.data.map((ticket) =>
                    <tr key={ticket.id} className="bg-white border-t dark:bg-gray-900 dark:border-gray-700">
                        <td scope="col" className="px-6 py-4">
                            {t(`transport.type.${ticket.transport_type}`)}
                        </td>
                        <td scope="col" className="px-6 py-4 text-center">
                            {t(`tickets.type.${ticket.ticket_type}`)}
                        </td>
                        <td scope="col" className="px-6 py-4 text-center">
                            {ticket.price}
                        </td>
                        <td scope="col" className="px-6 py-4 text-center">
                            <Link href={route('tickets.edit', {city: cityId, ticket: ticket.id})}
                                  className="font-xmedium text-green-700 dark:text-green-600 hover:underline">
                                {t(`operations.edit`)}

                            </Link>
                        </td>
                        <td scope="col" className="px-6 py-4 text-center">
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
