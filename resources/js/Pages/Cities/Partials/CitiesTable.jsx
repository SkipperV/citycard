import {Link} from "@inertiajs/react";
import Pagination from "@/Components/Pagination.jsx";
import {useTranslation} from "react-i18next";
import {useMutation, useQueryClient} from "@tanstack/react-query";

export default function CitiesTable({cities}) {
    const {t} = useTranslation();
    const queryClient = useQueryClient();

    const mutation = useMutation({
        mutationFn: async ({cityId}) => {
            return await axios.delete(route('api.cities.destroy', {city: cityId}));
        },
        onSuccess: () => {
            queryClient.invalidateQueries('citiesData');
        },
        onError: (error) => {
            console.error('Error deleting city:', error);
        }
    });

    const deleteCity = (cityId) => {
        mutation.mutate({cityId});
    }

    return (
        <div className="relative overflow-x-auto shadow-md sm:rounded-lg rounded dark:border dark:border-gray-600">
            <table className="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col"
                        className="px-6 py-3 whitespace-nowrap w-max">{t(`cities.table.city_and_region`)}</th>
                    <th scope="col"
                        className="px-6 py-3 text-center whitespace-nowrap w-48">{t(`cities.table.transport`)}</th>
                    <th scope="col"
                        className="px-6 py-3 text-center whitespace-nowrap w-48">{t(`cities.table.tickets`)}</th>
                    <th scope="col"
                        className="px-6 py-3 text-center whitespace-nowrap w-32">{t(`operations.edit`)}</th>
                    <th scope="col"
                        className="px-6 py-3 text-center whitespace-nowrap w-32">{t(`operations.delete`)}</th>
                </tr>
                </thead>
                <tbody>
                {cities.data.map((city) =>
                    <tr key={city.id} className="bg-white border-t dark:bg-gray-900 dark:border-gray-700">
                        <td scope="col" className="px-6 py-4">
                            {city.name}, {city.region}
                        </td>
                        <td scope="col" className="px-6 py-4 text-center">
                            <Link href={route("transport.index", {city: city.id})}
                                  className="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                {t(`cities.table.view_transport`)}
                            </Link>
                        </td>
                        <td scope="col" className="px-6 py-4 text-center">
                            <Link href={route("tickets.index", {city: city.id})}
                                  className="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                {t(`cities.table.view_tickets`)}
                            </Link>
                        </td>
                        <td scope="col" className="px-6 py-4 text-center">
                            <Link href={route("cities.edit", {city: city.id})}
                                  className="font-medium text-green-700 dark:text-green-600 hover:underline">
                                {t(`operations.edit`)}
                            </Link>
                        </td>
                        <td scope="col" className="px-6 py-4 text-center max-w-fit">
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
