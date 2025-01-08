import {Link} from "@inertiajs/react";
import {useTranslation} from "react-i18next";
import {useMutation, useQueryClient} from "@tanstack/react-query";
import {useState} from "react";

export default function TicketElement({cityId, ticket, deleteButtonsDisabled, updateDeleteButtonsDisabled}) {
    const {t} = useTranslation();
    const queryClient = useQueryClient();
    const [isDeleted, setIsDeleted] = useState(false);

    const mutation = useMutation({
        mutationFn: async ({ticketId}) => {
            updateDeleteButtonsDisabled(true);
            return await axios.delete(route('api.tickets.destroy', {city: cityId, ticket: ticketId}));
        },
        onSuccess: () => {
            queryClient.invalidateQueries('ticketsData');
            setIsDeleted(true);
        },
        onError: (error) => {
            console.error('Error deleting ticket:', error);
        },
        onSettled: () => {
            updateDeleteButtonsDisabled(false);
        }
    });

    const deleteTicket = (ticketId) => {
        mutation.mutate({ticketId});
    }

    return (
        <tr className="bg-white border-t dark:bg-gray-900 dark:border-gray-700">
            <td scope="col"
                className={"px-6 py-4 " + (mutation.isPending ? "opacity-80" : isDeleted ? "opacity-60 line-through" : "")}>
                {t(`transport.type.${ticket.transport_type}`)}
            </td>
            <td scope="col"
                className={"px-6 py-4 text-center " + (mutation.isPending ? "opacity-80" : isDeleted ? "opacity-60 line-through" : "")}>
                {t(`tickets.type.${ticket.ticket_type}`)}
            </td>
            <td scope="col"
                className={"px-6 py-4 text-center " + (mutation.isPending ? "opacity-80" : isDeleted ? "opacity-60 line-through" : "")}>
                {ticket.price}
            </td>
            <td scope="col" className="px-6 py-4 text-center">
                <Link href={route('tickets.edit', {city: cityId, ticket: ticket.id})}
                      as="button"
                      disabled={mutation.isPending || isDeleted}
                      className="font-medium text-green-700 dark:text-green-600 enabled:hover:underline disabled:opacity-60">
                    {t('operations.edit')}
                </Link>
            </td>
            <td scope="col" className="px-6 py-4 text-center">
                <button onClick={() => deleteTicket(ticket.id)}
                        className="text-red-600 font-medium enabled:hover:underline disabled:opacity-60"
                        disabled={deleteButtonsDisabled || isDeleted}>
                    {
                        mutation.isPending
                            ? t('operations.in_progress_deleting')
                            : t('operations.delete')
                    }
                </button>
            </td>
        </tr>
    );
}
