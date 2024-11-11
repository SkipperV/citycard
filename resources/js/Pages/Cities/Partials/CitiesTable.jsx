import {Link, router} from "@inertiajs/react";
import Pagination from "@/Components/Pagination.jsx";

export default function CitiesTable({cities}) {
    const deleteCity = (id) => {
        router.delete(route("cities.destroy", id));
    }

    return (
        <div className="relative overflow-x-auto shadow-md sm:rounded-lg rounded dark:border dark:border-gray-600">
            <table className="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" className="px-6 py-3">Місто, область</th>
                    <th scope="col" className="px-6 py-3">Транспорт</th>
                    <th scope="col" className="px-6 py-3">Квитки</th>
                    <th scope="col" className="px-6 py-3">Редагувати</th>
                    <th scope="col" className="px-6 py-3">Видалити</th>
                </tr>
                </thead>
                <tbody>
                {cities.data.map((city) =>
                    <tr key={city.id} className="bg-white border-t dark:bg-gray-900 dark:border-gray-700">
                        <td scope="col" className="px-6 py-4">
                            {city.name}, {city.region}
                        </td>
                        <td scope="col" className="px-6 py-4">
                            <Link href={route("transport.index", city.id)}
                                  className="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                Переглянути транспорт
                            </Link>
                        </td>
                        <td scope="col" className="px-6 py-4">
                            <Link href={route("tickets.index", city.id)}
                                  className="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                Переглянути типи та ціни квитків
                            </Link>
                        </td>
                        <td scope="col" className="px-6 py-4">
                            <Link href={route("cities.edit", city.id)}
                                  className="font-medium text-green-700 dark:text-green-600 hover:underline">
                                Редагувати
                            </Link>
                        </td>
                        <td scope="col" className="px-6 py-4">
                            <button onClick={() => deleteCity(city.id)}
                                    className="text-red-600 font-medium hover:underline">
                                Видалити
                            </button>
                        </td>
                    </tr>
                )}
                </tbody>
            </table>
            <Pagination links={cities.links} />
        </div>
    );
}
