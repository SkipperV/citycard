import {Link} from "@inertiajs/react";
import {useTranslation} from "react-i18next";
import {useMutation, useQueryClient} from "@tanstack/react-query";

export default function TransportTable({transportRoutes, cityId}) {
    const {t} = useTranslation();
    const queryClient = useQueryClient();

    const mutation = useMutation({
        mutationFn: async ({transportRouteId}) => {
            return await axios.delete(route('api.transport.destroy', {city: cityId, transportRoute: transportRouteId}));
        },
        onSuccess: () => {
            queryClient.invalidateQueries('transportsData');
        },
        onError: (error) => {
            console.error('Error deleting transport route:', error);
        }
    });

    const deleteTransport = (transportRouteId) => {
        mutation.mutate({transportRouteId});
    }

    return (
        <div className="relative overflow-x-auto shadow-md sm:rounded-lg rounded dark:border dark:border-gray-600">
            <table className="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col"
                        className="px-6 py-3 text-center whitespace-nowrap w-32">{t("transport.table.route_number")}</th>
                    <th scope="col"
                        className="px-6 py-3 text-center whitespace-nowrap w-64">{t("transport.table.transport_type")}</th>
                    <th scope="colgroup" colSpan="2"
                        className="pl-6 py-3 text-center whitespace-nowrap w-max">{t("transport.table.endpoints")}</th>
                    <th scope="col" className="px-6 py-3 text-center whitespace-nowrap w-32">{t("operations.edit")}</th>
                    <th scope="col" className="px-6 py-3 text-center whitespace-nowrap w-32">{t("operations.delete")}</th>
                </tr>
                </thead>
                <tbody>
                {transportRoutes.data.map((transportRoute) =>
                    <tr key={transportRoute.id} className="bg-white border-t dark:bg-gray-900 dark:border-gray-700">
                        <td scope="col" className="px-6 py-4 text-center">
                            {transportRoute.route_number}
                        </td>
                        <td scope="col" className="px-6 py-4 text-center">
                            {t(`transport.type.${transportRoute.transport_type}`)}
                        </td>
                        <td scope="col" className="px-6 py-4 text-center">
                            {transportRoute.route_endpoint_1}
                        </td>
                        <td scope="col" className="px-6 py-4 text-center">
                            {transportRoute.route_endpoint_2}
                        </td>
                        <td className="px-6 py-4 text-center">
                            <Link href={route('transport.edit', {city: cityId, transportRoute: transportRoute.id})}
                                  className="font-medium text-green-700 dark:text-green-600 hover:underline">
                                {t(`operations.edit`)}
                            </Link>
                        </td>
                        <td scope="col" className="px-6 py-4 text-center">
                            <button onClick={() => deleteTransport(transportRoute.id)}
                                    className="text-red-600 font-medium">
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
