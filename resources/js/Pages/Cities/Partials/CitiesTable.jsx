import {Link, router} from "@inertiajs/react";
import Pagination from "@/Components/Pagination.jsx";
import {useTranslation} from "react-i18next";

export default function CitiesTable({cities}) {
    const {t} = useTranslation()

    const deleteCity = (id) => {
        router.delete(route("cities.destroy", id));
    }

    return (
        <div className="relative overflow-x-auto shadow-md sm:rounded-lg rounded dark:border dark:border-gray-600">
            <table className="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" className="px-6 py-3">{t(`cities.table.city_and_region`)}</th>
                    <th scope="col" className="px-6 py-3">{t(`cities.table.transport`)}</th>
                    <th scope="col" className="px-6 py-3">{t(`cities.table.tickets`)}</th>
                    <th scope="col" className="px-6 py-3">{t(`operations.edit`)}</th>
                    <th scope="col" className="px-6 py-3">{t(`operations.delete`)}</th>
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
                                {t(`cities.table.view_transport`)}
                            </Link>
                        </td>
                        <td scope="col" className="px-6 py-4">
                            <Link href={route("tickets.index", city.id)}
                                  className="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                {t(`cities.table.view_tickets`)}
                            </Link>
                        </td>
                        <td scope="col" className="px-6 py-4">
                            <Link href={route("cities.edit", city.id)}
                                  className="font-medium text-green-700 dark:text-green-600 hover:underline">
                                {t(`operations.edit`)}
                            </Link>
                        </td>
                        <td scope="col" className="px-6 py-4">
                            <button onClick={() => deleteCity(city.id)}
                                    className="text-red-600 font-medium hover:underline">
                                {t(`operations.delete`)}
                            </button>
                        </td>
                    </tr>
                )}
                </tbody>
            </table>
            <Pagination links={cities.links}/>
        </div>
    );
}
