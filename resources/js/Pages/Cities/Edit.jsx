import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.jsx';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import {Head, Link, router} from '@inertiajs/react';
import {useTranslation} from "react-i18next";
import {useState} from "react";
import {useMutation} from "@tanstack/react-query";

export default function Edit({auth, status, city}) {
    const {t} = useTranslation();

    const [region, setRegion] = useState(city.region);
    const [name, setName] = useState(city.name);
    const [errors, setErrors] = useState({});

    const mutation = useMutation({
        mutationFn: async ({name, region}) => {
            return await axios.put(route('api.cities.update', {city: city.id}), {name: name, region: region});
        },
        onSuccess: () => {
            setErrors({});
            router.visit(route('cities.index'));
        },
        onError: (error) => {
            setErrors(error.response.data.errors);
        }
    });

    const submit = (e) => {
        e.preventDefault();
        mutation.mutate({name, region});
    };

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <div className="relative w-full h-6">
                    <Link href={route('cities.index')}>
                        <svg className="absolute left-3 top-1 h-4 text-gray-800 hover:cursor-pointer dark:text-white"
                             aria-hidden="true"
                             xmlns="http://www.w3.org/2000/svg"
                             fill="none"
                             viewBox="0 0 8 14">
                            <path stroke="currentColor" strokeLinecap="round" strokeLinejoin="round" strokeWidth="2"
                                  d="M7 1 1.3 6.326a.91.91 0 0 0 0 1.348L7 13"/>
                        </svg>
                    </Link>
                    <h2 className="absolute left-1/2 transform -translate-x-1/2 top-0 h-full font-semibold text-xl text-gray-800 leading-tight dark:text-gray-300 text-center">
                        {t('cities.title.update')}
                    </h2>
                </div>
            }>
            <Head title={t('cities.title.update')}/>

            {status && <div className="mb-4 font-medium text-sm text-green-600">{status}</div>}

            <div className="max-w-7xl mx-auto">
                <div className="w-96 mx-auto">
                    <form onSubmit={submit}>
                        <div className="mt-4">
                            <InputLabel htmlFor="region" className="dark:text-gray-300"
                                        value={t('cities.field.region')}/>

                            <TextInput
                                id="region"
                                type="text"
                                name="region"
                                value={region}
                                className="mt-1 block w-full"
                                onChange={(e) => setRegion(e.target.value)}
                            />
                            {
                                errors.region && errors.region.map((err, index) => (
                                    <InputError key={index} message={err} className="mt-2"/>
                                ))
                            }
                        </div>

                        <div className="mt-4">
                            <InputLabel htmlFor="name" className="dark:text-gray-300" value={t('cities.field.name')}/>

                            <TextInput
                                id="name"
                                type="text"
                                name="name"
                                value={name}
                                className="mt-1 block w-full"
                                onChange={(e) => setName(e.target.value)}
                            />
                            {
                                errors.name && errors.name.map((err, index) => (
                                    <InputError key={index} message={err} className="mt-2"/>
                                ))
                            }
                        </div>

                        <div className="mt-4 flex">
                            <PrimaryButton className="mx-auto" disabled={mutation.isPending}>
                                {t('operations.save')}
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
