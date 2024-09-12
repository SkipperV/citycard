import {useEffect} from 'react';
import GuestLayout from '@/Layouts/GuestLayout';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import {Head, Link, useForm} from '@inertiajs/react';

export default function Register() {
    const {data, setData, post, processing, errors, reset} = useForm({
        login: '',
        card_number: '',
        password: '',
        password_confirmation: '',
    });

    useEffect(() => {
        return () => {
            reset('password', 'password_confirmation');
        };
    }, []);

    const submit = (e) => {
        e.preventDefault();

        post(route('register'));
    };

    return (
        <GuestLayout>
            <Head title="Реєстрація"/>

            <form onSubmit={submit}>
                <div>
                    <InputLabel htmlFor="login" className="dark:text-gray-300" value="Номер телефону"/>

                    <TextInput
                        id="login"
                        name="login"
                        value={data.login}
                        className="mt-1 block w-full"
                        autoComplete="login"
                        isFocused={true}
                        onChange={(e) => setData('login', e.target.value)}
                        required
                    />

                    <InputError message={errors.login} className="mt-2"/>
                </div>

                <div className="mt-4">
                    <InputLabel htmlFor="card_number" className="dark:text-gray-300"
                                value="Номер проїздної картки (не обовʼязково)"/>

                    <TextInput
                        id="card_number"
                        // type="email"
                        name="card_number"
                        value={data.email}
                        className="mt-1 block w-full"
                        autoComplete="card_number"
                        onChange={(e) => setData('card_number', e.target.value)}
                        required
                    />

                    <InputError message={errors.card_number} className="mt-2"/>
                </div>

                <div className="mt-4">
                    <InputLabel htmlFor="password" className="dark:text-gray-300" value="Пароль"/>

                    <TextInput
                        id="password"
                        type="password"
                        name="password"
                        value={data.password}
                        className="mt-1 block w-full"
                        autoComplete="new-password"
                        onChange={(e) => setData('password', e.target.value)}
                        required
                    />

                    <InputError message={errors.password} className="mt-2"/>
                </div>

                <div className="mt-4">
                    <InputLabel htmlFor="password_confirmation"
                                className="dark:text-gray-300"
                                value="Підтвердження паролю"/>

                    <TextInput
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        value={data.password_confirmation}
                        className="mt-1 block w-full"
                        autoComplete="new-password"
                        onChange={(e) => setData('password_confirmation', e.target.value)}
                        required
                    />

                    <InputError message={errors.password_confirmation} className="mt-2"/>
                </div>

                <div className="flex items-center justify-end mt-4">
                    <Link
                        href={route('login')}
                        className="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:text-gray-400 dark:hover:text-gray-200"
                    >
                        Вже маєте обліковий запис?
                    </Link>

                    <PrimaryButton className="ms-4 dark:bg-gray-700 dark:hover:bg-gray-600" disabled={processing}>
                        Зареєструватися
                    </PrimaryButton>
                </div>
            </form>
        </GuestLayout>
    );
}
