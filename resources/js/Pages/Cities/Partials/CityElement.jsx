import {Link} from "@inertiajs/react";
import {useTranslation} from "react-i18next";
import {useMutation, useQueryClient} from "@tanstack/react-query";
import {useState} from "react";

export default function CityElement({city, deleteButtonsDisabled, updateDeleteButtonsDisabled}) {
    const {t} = useTranslation();
    const queryClient = useQueryClient();
    const [isDeleted, setIsDeleted] = useState(false);

    const mutation = useMutation({
        mutationFn: async ({cityId}) => {
            updateDeleteButtonsDisabled(true);
            return await axios.delete(route('api.cities.destroy', {city: cityId}));
        },
        onSuccess: () => {
            queryClient.invalidateQueries('citiesData');
            setIsDeleted(true);
        },
        onError: (error) => {
            console.error('Error deleting city:', error);
        },
        onSettled: () => {
            updateDeleteButtonsDisabled(false);
        }
    });

    const deleteCity = (cityId) => {
        mutation.mutate({cityId});
    }

    return (
        <tr className="bg-white border-t dark:bg-gray-900 dark:border-gray-700">
            <td scope="col"
                className={'px-6 py-4 ' + (mutation.isPending ? 'opacity-80' : isDeleted ? 'opacity-60 line-through' : '')}>
                {city.name}, {city.region}
            </td>
            <td scope="col" className="px-6 py-4 text-center">
                <Link href={route('transport.index', {city: city.id})}
                      as="button"
                      disabled={mutation.isPending || isDeleted}
                      className="font-medium text-blue-600 dark:text-blue-500 enabled:hover:underline disabled:opacity-60">
                    {t('cities.table.view_transport')}
                </Link>
            </td>
            <td scope="col" className="px-6 py-4 text-center">
                <Link href={route("tickets.index", {city: city.id})}
                      as="button"
                      disabled={mutation.isPending || isDeleted}
                      className="font-medium text-blue-600 dark:text-blue-500 enabled:hover:underline disabled:opacity-60">
                    {t('cities.table.view_tickets')}
                </Link>
            </td>
            <td scope="col" className="px-6 py-4 text-center">
                <Link href={route("cities.edit", {city: city.id})}
                      as="button"
                      disabled={mutation.isPending || isDeleted}
                      className="font-medium text-green-700 dark:text-green-600 enabled:hover:underline disabled:opacity-60">
                    {t('operations.edit')}
                </Link>
            </td>
            <td scope="col" className="px-6 py-4 text-center max-w-fit">
                <button onClick={() => deleteCity(city.id)}
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
