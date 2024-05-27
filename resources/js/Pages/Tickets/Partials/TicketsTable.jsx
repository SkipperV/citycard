import {Link, router} from "@inertiajs/react";

export default function TicketsTable({tickets, cityId}) {
    const deleteTicket = (id) => {
        router.delete(route('tickets.destroy', [cityId, id]));
    }

    return (
        <div className="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table className="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" className="px-6 py-3">Тип транспорту</th>
                    <th scope="col" className="px-6 py-3">Тип квитка</th>
                    <th scope="col" className="px-6 py-3">Ціна</th>
                    <th scope="col" className="px-6 py-3">Редагувати</th>
                    <th scope="col" className="px-6 py-3">Видалити</th>
                </tr>
                </thead>
                <tbody>
                {tickets.map((ticket) =>
                    <tr key={ticket.id} className="bg-white border-t dark:bg-gray-900 dark:border-gray-700">
                        <td scope="col" className="px-6 py-4">
                            {ticket.transport_type}
                        </td>
                        <td scope="col" className="px-6 py-4">
                            {ticket.ticket_type}
                        </td>
                        <td scope="col" className="px-6 py-4">
                            {ticket.price}
                        </td>
                        <td className="px-6 py-4">
                            <Link href={route('tickets.edit', [cityId, ticket.id])}
                                  className="font-xmedium text-green-700 dark:text-green-600 hover:underline">
                                Редагувати
                            </Link>
                        </td>
                        <td scope="col" className="px-6 py-4">
                            <button onClick={() => deleteTicket(ticket.id)} className="text-red-600 font-medium">
                                Видалити
                            </button>
                        </td>
                    </tr>
                )}
                </tbody>
            </table>
        </div>
    );
}
