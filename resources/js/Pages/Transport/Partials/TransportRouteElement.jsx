import {Link} from "@inertiajs/react";
import {useTranslation} from "react-i18next";
import {useMutation, useQueryClient} from "@tanstack/react-query";
import {useState} from "react";

export default function TransportRouteElement({
                                                  cityId,
                                                  transportRoute,
                                                  deleteButtonsDisabled,
                                                  updateDeleteButtonsDisabled
                                              }) {
    const {t} = useTranslation();
    const queryClient = useQueryClient();
    const [isDeleted, setIsDeleted] = useState(false);

    const mutation = useMutation({
        mutationFn: async ({transportRouteId}) => {
            updateDeleteButtonsDisabled(true);
            return await axios.delete(route('api.transport.destroy', {city: cityId, transportRoute: transportRouteId}));
        },
        onSuccess: () => {
            queryClient.invalidateQueries('transportsData');
            setIsDeleted(true);
        },
        onError: (error) => {
            console.error('Error deleting transport route:', error);
        },
        onSettled: () => {
            updateDeleteButtonsDisabled(false);
        }
    });

    const deleteTransport = (transportRouteId) => {
        mutation.mutate({transportRouteId});
    }

    return (
        <tr className="bg-white border-t dark:bg-gray-900 dark:border-gray-700">
            <td scope="col"
                className={'px-6 py-4 text-center ' + (mutation.isPending ? 'opacity-80' : isDeleted ? 'opacity-60 line-through' : '')}>
                {transportRoute.route_number}
            </td>
            <td scope="col"
                className={'px-6 py-4 text-center ' + (mutation.isPending ? 'opacity-80' : isDeleted ? 'opacity-60 line-through' : '')}>
                {t(`transport.type.${transportRoute.transport_type}`)}
            </td>
            <td scope="col"
                className={'px-6 py-4 text-center ' + (mutation.isPending ? 'opacity-80' : isDeleted ? 'opacity-60 line-through' : '')}>
                {transportRoute.route_endpoint_1}
            </td>
            <td scope="col"
                className={'px-6 py-4 text-center ' + (mutation.isPending ? 'opacity-80' : isDeleted ? 'opacity-60 line-through' : '')}>
                {transportRoute.route_endpoint_2}
            </td>
            <td className="px-6 py-4 text-center">
                <Link href={route('transport.edit', {city: cityId, transportRoute: transportRoute.id})}
                      as="button"
                      disabled={mutation.isPending || isDeleted}
                      className="font-medium text-green-700 dark:text-green-600 enabled:hover:underline disabled:opacity-60">
                    {t('operations.edit')}
                </Link>
            </td>
            <td scope="col" className="px-6 py-4 text-center">
                <button onClick={() => deleteTransport(transportRoute.id)}
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
