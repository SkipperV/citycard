import {Link, router} from "@inertiajs/react";

export default function TransportTable({transports, cityId}) {
    const deleteTransport = (id) => {
        router.delete(route('transport.destroy', [cityId, id]));
    }

    return (
        <div className="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table className="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" className="px-6 py-3">Номер маршруту</th>
                    <th scope="col" className="px-6 py-3">Тип транспорту</th>
                    <th scope="col" className="px-6 py-3">Кінцева 1</th>
                    <th scope="col" className="px-6 py-3">Кінцева 2</th>
                    <th scope="col" className="px-6 py-3">Редагувати</th>
                    <th scope="col" className="px-6 py-3">Видалити</th>
                </tr>
                </thead>
                <tbody>
                {transports.map((transportRoute) =>
                    <tr key={transportRoute.id} className="bg-white border-t dark:bg-gray-900 dark:border-gray-700">
                        <td scope="col" className="px-6 py-4">
                            {transportRoute.route_number}
                        </td>
                        <td scope="col" className="px-6 py-4">
                            {transportRoute.transport_type}
                        </td>
                        <td scope="col" className="px-6 py-4">
                            {transportRoute.route_endpoint_1}
                        </td>
                        <td scope="col" className="px-6 py-4">
                            {transportRoute.route_endpoint_2}
                        </td>
                        <td className="px-6 py-4">
                            <Link href={route('transport.edit', [cityId, transportRoute.id])}
                                  className="font-medium text-green-700 dark:text-green-600 hover:underline">
                                Редагувати
                            </Link>
                        </td>
                        <td scope="col" className="px-6 py-4">
                            <button onClick={() => deleteTransport(transportRoute.id)}
                                    className="text-red-600 font-medium">
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
